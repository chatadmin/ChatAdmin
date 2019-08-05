<?php


namespace App\Http\Modules;

use App\Http\Constant\CommonlyConstant;
use App\Model\Entity\UserFriend;
use Swoft\Db\DB;

class FriendModules
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
    public static function getFriendList(array $where , int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['id'])){
            $nWhere['user_friend.self_uid'] = (int) $where['id'];
        }

        $objModel = DB::table('user_friend');
        $objModel->join('user','user.id','=','user_friend.self_uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        //$objModel->where('user_friend.add_to',CommonlyConstant::CHAT_USER_FRIEND_ADD_TO_ONE);
        $countObjModel = &$objModel;
        $count = $countObjModel->count();
        $info = $objModel->select('user_friend.self_uid','user_friend.friend_uid','user_friend.remarks_name','user.phone'
            ,'user_friend.source','user.sex','user.region','user_friend.create_time','user.wallet','user.is_normal'
            ,'user_friend.black_to','user_friend.status','user.username')->offset($start)->limit($limit)->get()->toArray();

        if(!empty($info)){
            foreach($info as $key=>$val){
                $friendInfo = [];
                $objModel = DB::table('user_friend');
                $objModel->join('user','user.id','=','user_friend.self_uid');
                $objModel->where('user_friend.self_uid',$val['friend_uid']);
                $objModel->select('user_friend.self_uid','user_friend.friend_uid','user_friend.remarks_name','user.phone'
                    ,'user_friend.source','user.sex','user.region','user_friend.create_time','user.wallet','user.is_normal'
                    ,'user_friend.black_to','user_friend.status','user.username');
                $friendInfo = $objModel->first();
                $info[$key]['friendInfo'] = $friendInfo;
                $info[$key]['friendName'] = $friendInfo['username'];
            }

        }
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }

}
