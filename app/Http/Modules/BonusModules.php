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

class BonusModules
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
    public static function getSingleBonusList(array $where, int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['id'])){
            $nWhere['single_red_envelopes.uid'] = (int) $where['id'];
        }

        if(!empty($where['status'])){
            $nWhere['single_red_envelopes.status'] = $where['status'];
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

        $objModel = DB::table('single_red_envelopes');
        $objModel->join('user','user.id','=','single_red_envelopes.uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('single_red_envelopes.create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('user.username','user.phone','single_red_envelopes.id','single_red_envelopes.topic'
            ,'single_red_envelopes.status','single_red_envelopes.amount_red','single_red_envelopes.uid','single_red_envelopes.accept_uid'
            ,'single_red_envelopes.unique_value','single_red_envelopes.create_time')->offset($start)->limit($limit)->get()->toArray();
        if(!empty($info)){
            foreach ($info as $key=>$val){
                $userResource = null;
                $userResource = User::where('id',$val['accept_uid'])->first();
                if(!empty($userResource)){
                    $userInfo = $userResource->toArray();
                    $info[$key]['user_vname'] = $userInfo['username'];
                }else{
                    $info[$key]['user_vname'] = null;
                }

            }
        }
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }


    /**
     * 个人红包退还
     * @param array $where
     * @return bool
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public static function singleBonusBack(array $where):bool
    {
        if(empty($where) || empty($where['ids'])){
            return false;
        }
        $ids = $where['ids'] ?? [];

        if( count($ids) == 1 ){
            return self::TransactionSingleBonusBack($ids[0]);
        }else{
            $return = false;
            foreach ($ids as $val){
                if(!empty($val)){
                    $return = self::TransactionSingleBonusBack($val);
                }
            }
            return $return;
        }

    }


    /**
     * 群组红包退还
     * @param array $where
     * @return bool
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public static function groupBonusBack(array $where):bool
    {
        if(empty($where) || empty($where['ids'])){
            return false;
        }
        $ids = $where['ids'] ?? [];

        if( count($ids) == 1 ){
            return self::TransactionGroupBonusBack($ids[0]);
        }else{
            $return = false;
            foreach ($ids as $val){
                if(!empty($val)){
                    $return = self::TransactionGroupBonusBack($val);
                }
            }
            return $return;
        }

    }


    /**
     * 个人红包退还事务
     * @param int $id
     * @return bool
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    private static function TransactionSingleBonusBack(int $id){
        if(empty($id))
        {
            return false;
        }

        DB::connection()->beginTransaction();
        try{
            $bonusInfo = [];
            $bonusResource = SingleRedEnvelopes::where('id',$id)->first();

            if(!empty($bonusResource)){
                $bonusInfo = $bonusResource->toArray();
            }
            if(empty($bonusInfo)){
                DB::connection()->rollBack();
                return false;
            }


            $tableObj = DB::table('single_red_envelopes');
            $tableObj->where('id',$id);
            $tableObj->where('status',CommonlyConstant::CHAT_SINGLE_BONUS_STATUS_ONE);

            if(!$tableObj->update(['status'=>CommonlyConstant::CHAT_SINGLE_BONUS_STATUS_THREE])){

                DB::connection()->rollBack();
                return false;
            }

            if(!DB::update("update `dgg_user` set `wallet` = `wallet` + ".$bonusInfo['amountRed'].' where id= ?' , [$bonusInfo['uid']])){
                DB::connection()->rollBack();
                return false;
            }

            if(!DB::insert("insert `dgg_account`(`amount_count`,`uid`,`status`,`create_time`) values(".$bonusInfo['amountRed']
                .",".$bonusInfo['uid'].",".CommonlyConstant::CHAT_USER_RECHARGE_STATUS_SINGLE_RETURN.",".time().')')){
                DB::connection()->rollBack();
                return false;
            }

            DB::connection()->commit();
            return true;

        } catch (\Exception $exception){
            DB::connection()->rollBack();
            return false;
        }
    }


    /**
     * 群组红包退还事务
     * @param int $id
     * @return bool
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    private static function TransactionGroupBonusBack(int $id){
        if(empty($id))
        {
            return false;
        }

        DB::connection()->beginTransaction();
        try{
            $bonusInfo = [];
            $bonusResource = GroupRedEnvelopes::where('id',$id)->first();

            if(!empty($bonusResource)){
                $bonusInfo = $bonusResource->toArray();
            }
            if(empty($bonusInfo)){
                DB::connection()->rollBack();
                return false;
            }
            $redis = Redis::connection(CommonlyConstant::REDIS_POOL_TWO);
            $totalAmount = 0;
            $unreceived = 0;
            $pushData = [];
            for ($i = 1;$i <= $bonusInfo['number'];$i++){
                if($amount = $redis->lPop(CommonlyConstant::REDIS_WECHAT_GROUP_BONUS_KEY.$id)){
                    $pushData[] = $amount;
                    $totalAmount = bcadd($amount,$totalAmount,2);
                    $unreceived +=1;
                }
                $amount = null;
                continue;
            }

            if(!empty($pushData)){
                $tableObj = DB::table('group_red_envelopes');
                $tableObj->where('id',$id);
                $tableObj->where('status',CommonlyConstant::CHAT_GROUP_BONUS_STATUS_ONE);

                if(!$tableObj->update(['status'=>CommonlyConstant::CHAT_GROUP_BONUS_STATUS_TWO,'back_number'=>$unreceived,'back_amount'=>$totalAmount])){
                    foreach ($pushData as $pkey=>$pval){
                        $redis->lPush(CommonlyConstant::REDIS_WECHAT_GROUP_BONUS_KEY.$id,$pval);
                    }
                    DB::connection()->rollBack();
                    return false;
                }

                if(!DB::update("update `dgg_user` set `wallet` = `wallet` + ".$totalAmount.' where id= ?' , [$bonusInfo['uid']])){
                    foreach ($pushData as $pkey=>$pval){
                        $redis->lPush(CommonlyConstant::REDIS_WECHAT_GROUP_BONUS_KEY.$id,$pval);
                    }

                    DB::connection()->rollBack();
                    return false;
                }

                if(!DB::insert("insert `dgg_account`(`amount_count`,`uid`,`status`,`create_time`) values(".$bonusInfo['amountRed']
                    .",".$bonusInfo['uid'].",".CommonlyConstant::CHAT_USER_RECHARGE_STATUS_GROUP_RETURN.",".time().")")){
                    foreach ($pushData as $pkey=>$pval){
                        $redis->lPush(CommonlyConstant::REDIS_WECHAT_GROUP_BONUS_KEY.$id,$pval);
                    }
                    DB::connection()->rollBack();
                    return false;
                }

                DB::connection()->commit();
                return true;
            }else{

                DB::connection()->rollBack();
                return false;
            }


        } catch (\Exception $exception){
            DB::connection()->rollBack();
            return false;
        }
    }
    /**
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getGroupBonusList(array $where, int $page=1, int $limit=10):array {

        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['id'])){
            $nWhere['group_red_envelopes.uid'] = (int) $where['id'];
        }

        if(!empty($where['status'])){
            $nWhere['group_red_envelopes.status'] = $where['status'];
        }

        if(!empty($where['group_id'])){
            $nWhere['group_red_envelopes.group_id'] = $where['group_id'];
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

        $objModel = DB::table('group_red_envelopes');
        $objModel->join('user','user.id','=','group_red_envelopes.uid');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('group_red_envelopes.create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();

        $info = $objModel->select('user.username','user.phone','group_red_envelopes.id','group_red_envelopes.topic'
            ,'group_red_envelopes.status','group_red_envelopes.amount_red','group_red_envelopes.uid','group_red_envelopes.group_id'
            ,'group_red_envelopes.unique_value','group_red_envelopes.create_time','group_red_envelopes.number')->offset($start)->limit($limit)->get()->toArray();
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

                $received = CreateRed::where('group_red_id',$val['id'])->count();
                $receivedAmount = CreateRed::where('group_red_id',$val['id'])->sum('amount_red');

                $info[$key]['received'] = $received;
                $info[$key]['unreceived'] = bcsub($val['number'],$received);
                $info[$key]['receivedAmount'] = $receivedAmount;
                $info[$key]['unreceivedAmount'] = bcsub($val['amount_red'],$receivedAmount,2);

            }
        }
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];
    }

    /**
     * 返回红包领取详情
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static  function getDetailsListByGroupID(int $id , int $page =1 , int $limit=10 ) : array
    {

        $start = ($page-1)*$limit;
        if(empty($id) || $id < 0 ){
            $data['list'] = [];
            $data['count'] = 0;
        }

        $objModel = DB::table('create_red');
        $objModel->join('user','user.id','=','create_red.accept_uid');
        $objModel->where('create_red.group_red_id',$id);
        $countObjModel = &$objModel;
        $count = $countObjModel->count();
        $info = $objModel->select('user.id','user.username','user.phone','user.sex','user.wallet',
            'user.region','user.is_normal','create_red.amount_red','create_red.accept_time')->offset($start)->limit($limit)->get()->toArray();
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];
    }
}
