<?php


namespace App\Http\Modules;

use App\Http\Constant\CommonlyConstant;
use App\Model\Entity\CreateRed;
use App\Model\Entity\Group;
use App\Model\Entity\GroupRedEnvelopes;
use App\Model\Entity\SingleRedEnvelopes;
use App\Model\Entity\User;
use Swoft\Redis\Redis;
use Swoft\Db\DB;

class ChatModules
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
    public static function getSingleChatList(array $where, int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['sent_uid'])){
            $nWhere['single_chat.send_uid'] = (int) $where['sent_uid'];
        }

        if(!empty($where['accept_uid'])){
            $nWhere['single_chat.accept_uid'] = (int) $where['accept_uid'];
        }

        if(!empty($where['single_type'])){
            $nWhere['single_chat.type'] = $where['single_type'];
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

        $objModel = DB::table('single_chat');
        $objModel->join('user','user.id','=','single_chat.send_uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('single_chat.create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('user.username','user.phone','single_chat.id','single_chat.send_uid'
            ,'single_chat.accept_uid','single_chat.unique_value','single_chat.content','single_chat.from'
            ,'single_chat.type','single_chat.create_time')->offset($start)->limit($limit)->get()->toArray();
        if(!empty($info)){
            foreach ($info as $key=>$val){
                $userResource = null;
                $userResource = User::where('id',$val['accept_uid'])->first();
                if(!empty($userResource)){
                    $userInfo = $userResource->toArray();
                    $info[$key]['acceptName'] = $userInfo['username'];
                    $info[$key]['acceptPhone'] = $userInfo['phone'];
                }else{
                    $info[$key]['acceptName'] = null;
                }

            }
        }
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }

    /**
     * 返回群组聊天信息列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getGroupChatList(array $where, int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['sent_uid'])){
            $nWhere['single_chat.send_uid'] = (int) $where['sent_uid'];
        }

        if(!empty($where['group_id'])){
            $nWhere['single_chat.group_id'] = (int) $where['group_id'];
        }

        if(!empty($where['group_type'])){
            $nWhere['single_chat.type'] = $where['group_type'];
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

        $objModel = DB::table('group_chat');
        $objModel->join('user','user.id','=','group_chat.send_uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('group_chat.create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('user.username','user.phone','group_chat.id','group_chat.send_uid'
            ,'group_chat.group_id','group_chat.unique_value','group_chat.content','group_chat.from'
            ,'group_chat.type','group_chat.create_time')->offset($start)->limit($limit)->get()->toArray();
        if(!empty($info)){
            foreach ($info as $key=>$val){
                $groupResource = null;
                $groupResource = Group::where('id',$val['group_id'])->first();
                if(!empty($groupResource)){
                    $groupInfo = $groupResource->toArray();
                    $info[$key]['group_name'] = $groupInfo['groupName'];
                }else{
                    $info[$key]['group_name'] = null;
                }

            }
        }
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];
    }


    /**
     * 个人聊天信息删除
     * @param array $where
     * @return bool
     */
    public static function singleChatDelete(array $where):bool
    {
        if( !isset($where['ids']) || empty($where['ids'])){
            return false;
        }

        try{
            $count = 0;
            if(!empty($where['ids'])){
                $count = count($where['ids']);
            }
            if($count == 1){

                if(!DB::delete("delete from `dgg_single_chat` where `id` = ? ",$where['ids'])){
                    return false;
                }

            }else if($count > 1){
                $idsstr = '';
                foreach ($where['ids'] as $wval){
                    if(!empty($wval))
                        $idsstr .= ','.$wval;
                }
                $idsstr = substr($idsstr,1,strlen($idsstr)-1);
                if(!DB::delete("delete from `dgg_single_chat` where `id` in ($idsstr)")){
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
     * 群组聊天信息删除
     * @param array $where
     * @return bool
     */
    public static function groupChatDelete(array $where):bool
    {
        if( empty($where['ids'])){
            return false;
        }

        try{
            $count = 0;
            if(!empty($where['ids'])){
                $count = count($where['ids']);
            }
            if($count == 1){

                if(!DB::delete("delete from `dgg_group_chat` where `id` = ? ",$where['ids'])){
                    return false;
                }

            }else if($count > 1){
                $idsstr = '';
                foreach ($where['ids'] as $wval){
                    if(!empty($wval))
                        $idsstr .= ','.$wval;
                }
                $idsstr = substr($idsstr,1,strlen($idsstr)-1);
                if(!DB::delete("delete from `dgg_group_chat` where `id` in ($idsstr)")){
                    return false;
                }
            }
            return true;
        }catch (\Exception $exception){
            print_r($exception->getMessage());
            return false;
        }

    }
}
