<?php


namespace App\Http\Modules;

use Swoft\Db\DB;

class CircleModules
{
    /**
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getCircleList(array $where , int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWhere = $nWherebetween =$data = $fromtime = $totime = null;

        if(!empty($where['id'])){
            $nWhere['friend_circle_message.uid'] = (int) $where['id'];
        }

        if(!empty($where['fromtime'])){
            $fromtime = strtotime($where['fromtime']);
        }
        if(!empty($where['totime'])){
            $totime = strtotime($where['totime']);
        }
        if(!empty($fromtime)){
            if(!empty($totime) && $totime > $fromtime){
                $nWherebetween['create_time'] = [$fromtime,$totime];
            }else{
                $nWherebetween['create_time'] = [$fromtime,time()];
            }


        }

        $objModel = DB::table('friend_circle_message');
        $objModel->join('user','user.id','=','friend_circle_message.uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('friend_circle_message.create_time',$nWherebetween['create_time']);
        }

        $countObjModel = &$objModel;
        $count = $countObjModel->count();
        $info = $objModel->select('friend_circle_message.id','friend_circle_message.uid','friend_circle_message.content','friend_circle_message.picture'
            ,'friend_circle_message.location','friend_circle_message.create_time','user.username','user.phone','user.sex','user.region','user.is_normal')
            ->offset($start)->limit($limit)->get()->toArray();
        if(!empty($info)){
            foreach($info as $key=>$val){
                if(!empty($val['picture'])){
                    $info[$key]['picture_arr'] = json_decode($val['picture'],true);
                }

            }
        }

        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }

    /**
     * 删除朋友圈数据
     * @param array $where
     * @return bool
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public static function CircleDelete(array  $where) : bool
    {
        if(empty($where) || empty($where['ids'])){
            return false;
        }

        DB::connection()->beginTransaction();
        try{
            $count = 0;
            if(!empty($where['ids'])){
                $count = count($where['ids']);
            }
            if($count == 1){

                if(!DB::delete("delete from `dgg_friend_circle_message` where `id` = ? ",$where['ids'])){

                    DB::connection()->rollBack();
                    return false;
                }
                $commentCount = DB::table('friend_circle_comment')->where('fcmid',$where['ids'][0])->count();
                if($commentCount > 0){
                    if(!DB::delete("delete from `dgg_friend_circle_comment` where `fcmid` = ? ",$where['ids'])){

                        DB::connection()->rollBack();
                        return false;
                    }
                }
                $likeCount = DB::table('friend_circle_like')->where('fcmid',$where['ids'][0])->count();
                if($likeCount > 0){
                    if(!DB::delete("delete from `dgg_friend_circle_like` where `fcmid` = ? ",$where['ids'])){

                        DB::connection()->rollBack();
                        return false;
                    }
                }

            }else if($count > 1){
                $idsstr = '';
                foreach ($where['ids'] as $wval){
                    $idsstr .= ','.$wval;
                }

                $idsstr = substr($idsstr,1,strlen($idsstr)-1);
                if(!DB::delete("delete from `dgg_friend_circle_message` where `id` in ($idsstr) ")){
                    DB::connection()->rollBack();
                    return false;
                }

                $commentCount = DB::table('friend_circle_comment')->whereIn('fcmid',$where['ids'])->count();
                if($commentCount > 0){
                    if(!DB::delete("delete from `dgg_friend_circle_comment` where `fcmid` in ($idsstr) ")){
                        DB::connection()->rollBack();
                        return false;
                    }
                }
                $likeCount = DB::table('friend_circle_like')->whereIn('fcmid',$where['ids'])->count();
                if($likeCount > 0){
                    if(!DB::delete("delete from `dgg_friend_circle_like` where `fcmid` in ($idsstr) ")){
                        DB::connection()->rollBack();
                        return false;
                    }
                }
            }

            DB::connection()->commit();
            return true;
        }catch (\Exception $exception){
            print_r($exception->getMessage());
            DB::connection()->rollBack();
            return false;
        }
    }

    /**
     * 评论删除
     * @param array $where
     * @return bool
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public static function CommentDelete(array  $where) : bool
    {
        if(empty($where) || empty($where['ids'])){
            return false;
        }
        try{
            $count = 0;
            if(!empty($where['ids'])){
                $count = count($where['ids']);
            }
            if($count == 1){

                if(!DB::delete("delete from `dgg_friend_circle_comment` where `id` = ? ",$where['ids'])){
                    return false;
                }

            }else if($count > 1){
                $idsstr = '';
                foreach ($where['ids'] as $wval){
                    $idsstr .= ','.$wval;
                }
                $idsstr = substr($idsstr,1,strlen($idsstr)-1);
                if(!DB::delete("delete from `dgg_friend_circle_comment` where `id` in ($idsstr)")){
                    return false;
                }
            }
            return true;
        }catch (\Exception $exception){
            print_r($exception->getMessage());
            return false;
        }
    }
    /**
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserListForLikeByCircleID(int $id,int $page=1, int $limit=10 ):array
    {
        $start = $limit*($page-1);
        if(empty($id))
        {
            return ['list'=>[] , 'count' =>0 ];
        }

        $objModel = DB::table('friend_circle_like');
        $objModel->join('user','user.id','=','friend_circle_like.uid');
        $objModel->where('fcmid',$id);

        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('friend_circle_like.id','friend_circle_like.uid','friend_circle_like.fcmid'
            ,'friend_circle_like.create_time','user.username','user.phone','user.sex','user.region')
            ->offset($start)->limit($limit)->get()->toArray();

        $data['list'] = $info;
        $data['count'] = $count;

        return $data;

    }

    /**
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserListForCommentByCircleID(int $id,int $page=1, int $limit=10 ):array
    {
        $start = $limit*($page-1);
        if(empty($id))
        {
            return ['list'=>[] , 'count' =>0 ];
        }

        $objModel = DB::table('friend_circle_comment');
        $objModel->join('user','user.id','=','friend_circle_comment.com_uid');
        $objModel->where('fcmid',$id);

        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('friend_circle_comment.id','friend_circle_comment.com_uid','friend_circle_comment.content','friend_circle_comment.fcmid'
            ,'friend_circle_comment.create_time','user.username','user.phone','user.sex','user.region')
            ->offset($start)->limit($limit)->get()->toArray();

        $data['list'] = $info;
        $data['count'] = $count;

        return $data;

    }

}
