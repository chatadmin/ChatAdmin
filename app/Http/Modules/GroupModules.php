<?php


namespace App\Http\Modules;

use App\Model\Entity\Group;
use Swoft\Db\DB;

class GroupModules
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
    public static function getGroupList(array $where, int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['owner_uid'])){
            $nWhere['group.owner_uid'] = (int) $where['owner_uid'];
        }

        if(!empty($where['group_name'])){
            $nWhere[] = ['group.group_name','like','%'.$where['group_name'].'%'];
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

        $objModel = DB::table('group');
        $objModel->join('user','user.id','=','group.owner_uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('group.create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();
        $info = $objModel->select('group.id','group.owner_uid','group.group_name','group.describe','group.create_time','user.username')->offset($start)->limit($limit)->get()->toArray();
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }

    /**
     * 通过群组ID获取组员
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserListByGroupID(int $id,int $page=1, int $limit=10):array
    {

        $start = ($page-1)*$limit;
        if(empty($id) || $id < 0 ){
            $data['list'] = [];
            $data['count'] = 0;
        }

        $objModel = DB::table('user_group_relation');
        $objModel->join('user','user.id','=','user_group_relation.uid');
        $objModel->where('user_group_relation.group_id',$id);
        $countObjModel = &$objModel;
        $count = $countObjModel->count();
        $info = $objModel->select('user.id','user.username','user.phone','user.nickname','user.birthday','user.sex','user.create_time','user.wallet',
            'user.region','user.is_normal','user_group_relation.user_name','user_group_relation.role','user_group_relation.status','user_group_relation.create_time','user.create_time')->offset($start)->limit($limit)->orderBy('user_group_relation.role')->orderByDesc('user_group_relation.id')->get()->toArray();
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];


    }

    /**
     * 通过群组名称获取信息
     * @param string $name
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function  getGroupInfoByName(string $name):array
    {
        if(empty($name)){
            return [];
        }
        $info = Group::where('group_name',$name)->first();
        if(!empty($info)){
            return $info->toArray();
        }
        return $info ?? [];
    }
}
