<?php


namespace App\Http\Modules;

use App\Http\Constant\CommonlyConstant;
use App\Model\Entity\User;
use Swoft\Db\DB;

class UserModules
{
    /**
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserList(array $where, int $page=1, int $limit=10):array
    {
        $start = ($page-1)*$limit;
        $nWherebetween = $nWhere = $data = $fromtime = $totime = null;

        if(!empty($where['id'])){
            $nWhere['id'] = (int) $where['id'];
        }

        if(!empty($where['phone'])){
            $nWhere['phone'] = (string) $where['phone'];
        }

        if(!empty($where['is_use']) && $where['is_use']==1){
            $nWhere['is_normal'] = 1;
        }else if(!empty($where['is_use']) && $where['is_use']==2){
            $nWhere['is_normal'] = 0;
        }
        if(!empty($where['username'])){
            $nWhere[] = ['username','like','%'.$where['username'].'%'];
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

        $objModel = DB::table('user');
        if($nWhere){
            $objModel->where($nWhere);
        }
        if($nWherebetween){
            $objModel->whereBetween('create_time',$nWherebetween['create_time']);
        }
        $countObjModel = &$objModel;
        $count = $countObjModel->count();
        $info = $objModel->select('id','username','phone','nickname','birthday','sex','region','create_time','signature','wallet','is_normal')->offset($start)->limit($limit)->get()->toArray();
        $data['list'] = $info;
        $data['count'] = $count;

        return $data ?? [];

    }

    /**
     * @param string $uname
     * @return array|object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function checkMemberByUname(string $uname)
    {
        $info = [];
        if($uname){
            $info = AdminMembers::where([['uname','=',$uname],['status','<',1]])->first();
            if(!empty($info)){
                return $info->toArray();
            }
        }
        return $info ?? [];
    }

    /**
     * @param int $id
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function checkMemberById(int $id)
    {
        $info = [];
        if(!empty($id)){
            $info = AdminMembers::where([['id','=',$id],['status','<',1]])->first();
            if(!empty($info)){
                return $info->toArray();
            }
        }
        return $info ?? [];
    }

    /**
     * @param array $where
     * @param array $param
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function Update(array $where,array $param):bool
    {
        if(empty($where) || empty($param)){
            return false;
        }

        $tableObj = DB::table('user');
        $whereTrue = false;
        if(!empty($where['whereIn'])){
            $whereTrue = true;
            $tableObj->whereIn($where['whereIn']['column'],$where['whereIn']['values']);
        }

        if(!empty($where['where'])){
            $whereTrue = true;
            $tableObj->where($where['where']);
        }

        if(!empty($where['whereOr'])){
            $whereTrue = true;
            $tableObj->orWhere($where['whereOr']);
        }

        if(!empty($where['whereBetween'])){
            $whereTrue = true;
            $tableObj->whereBetween($where['whereBetween']['column'],$where['whereBetween']['values']);
        }

        if(!empty($where['whereNotBetween'])){
            $whereTrue = true;
            $tableObj->whereNotBetween($where['whereNotBetween']['column'],$where['whereNotBetween']['values']);
        }

        if($whereTrue == false ){
            return false;
        }else if ($tableObj->update($param)){
            return true;
        }

        return false;
    }

    /**
     * 给用户充值
     * @param int $id
     * @param float $money
     * @return array
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public static function recharge(int $id,float $money):array {
        if(empty($id) || empty($money) || $id < 0 || $money < 0 ){
            return [];
        }
        DB::connection()->beginTransaction();
        try{
            if(DB::update("update `dgg_user` set `wallet` = `wallet` + ".$money.' where id= ?' , [$id])){
                if(DB::insert("insert into `dgg_account` (`amount_count`, `uid`,`status`,`create_time`) values (?, ?,?,?)", [$money, $id, CommonlyConstant::CHAT_USER_RECHARGE_STATUS_ADMIN, time()])){
                    DB::connection()->commit();
                    $info = User::where('id',$id)->select('wallet','id','username','nickname','phone')->first()->toArray();
                    return $info;
                }
                DB::connection()->rollBack();
                return [];
            }
            DB::connection()->rollBack();
            return [];
        }catch (\Exception $exception){

            DB::connection()->rollBack();
            return [];
        }

    }

    /**
     * @param int $id
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserInfoByID(int $id) : array
    {
        if(empty($id) || $id < 0 ){
            return [];
        }
        $info = User::where('id',$id)->select('id','username','phone','nickname','birthday','sex','signature','create_time','wallet','region','is_normal')->first();
        if(!empty($info)){
            return $info->toArray();
        }
        return $info ?? [];
    }


    /**
     * @param string $username
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserInfoByName(string $username) : array
    {
        if(empty($username) ){
            return [];
        }
        $info = User::where('username',$username)->first();
        if(!empty($info)){
            return $info->toArray();
        }
        return $info ?? [];
    }

    /**
     * @param string $phone
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getUserInfoByPhone(string $phone) : array
    {
        if(empty($phone) ){
            return [];
        }
        $info = User::where('phone',$phone)->first();
        if(!empty($info)){
            return $info->toArray();
        }
        return $info ?? [];
    }



}
