<?php


namespace App\Http\Modules;


use App\Http\Constant\CommonlyConstant;
use App\Http\Constant\MessageConstant;
use App\Model\Entity\AdminMembers;
use Swoft\Db\DB;

class AdminMembersModules
{
    /**
     * @param int $id
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function checkMember(int $id):array
    {

        if($id){
            $info = AdminMembers::find($id);
        }

        return $info ?? null;

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
            $info = AdminMembers::where(['uname'=>$uname,['status','<',1]])->first();
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
            $info = AdminMembers::where(['id'=>$id,['status','<',1]])->first();
            if(!empty($info)){
                return $info->toArray();
            }
        }
        return $info ?? [];
    }


    /**
     * 更新数据
     * @param array $where
     * @param array $param
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function update(array $where, array $param):bool
    {
        if(empty($where) || empty($param)){
            return false;
        }

        if(AdminMembers::where($where)->update($param))
        {
            return true;
        }

        return false;

    }


}
