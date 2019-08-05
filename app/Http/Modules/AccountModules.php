<?php


namespace App\Http\Modules;

use App\Model\Entity\Account;
use App\Model\Entity\Group;
use Swoft\Db\DB;

class AccountModules
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
    public static function getAccountList(array $where, int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['id'])){
            $nWhere['account.uid'] = (int) $where['id'];
        }

        if(!empty($where['group_id'])){
            $nWhere['account.group_id'] = $where['group_id'];
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

        $objModel = DB::table('account');
        $objModel->join('user','user.id','=','account.uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('account.create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('account.id','account.uid','account.amount_count','account.group_id','account.create_time'
            ,'account.status','user.username','user.phone')->offset($start)->limit($limit)->get()->toArray();
        if(!empty($info)){
            foreach ($info as $key=>$val){
                $groupResource = null;
                $groupResource = Group::where('id',$val['group_id'])->first();
                if(!empty($groupResource)){
                    $groupInfo = $groupResource->toArray();
                    $info[$key]['group_vname'] = $groupInfo['groupName'];
                }else{
                    $info[$key]['group_vname'] = null;
                }

            }
        }
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }

}
