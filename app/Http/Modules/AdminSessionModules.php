<?php


namespace App\Http\Modules;


use App\Model\Entity\AdminMembers;
use App\Model\Entity\AdminSession;

class AdminSessionModules
{
    /**
     * @param int $id
     * @return array
     */

    public static function getOneByID(int $id):array
    {

        $info = AdminSession::find($id, ['id','uid','username','session_key','access_time','is_online','state']);
        return $info;

    }

    /**
     * @param string $token
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getOneByToken(string $token):array
    {
        $info = AdminSession::where('session_key',$token)->first();
        return $info;
    }

    /**
     * @param array $where
     * @param array $select
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getInfoByWhere(array $where , array $select = array()):array
    {
        $objModel = AdminSession::where($where);

        if($select){
            foreach ($select as $val){
                $objModel->select($val);
            }
        }
        $info = $objModel->get();
        return $info;
    }


    /**
     * @param array $where
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function getOneByWhere(array $where ):array
    {
        if($where){
            $info = AdminSession::where($where)->orderBy('id','desc')->first();
            if(!empty($info)){
                return $info->toArray();
            }
        }
        return $info ?? [];
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function updateSession(int $id):bool{

        if($id){

            $update = [
                'access_time' => time()
            ];
            if(AdminSession::where('id',$id)->update($update)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * @param array $where
     * @param array $param
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function update(array $where,array $param):bool {
        if(empty($where) || empty($param)){
            return false;
        }
        if(AdminSession::where($where)->update($param))
        {
            return true;
        }
        return false;
    }
    /**
     * @param array $memberInfo
     * @param string $token
     * @param string $ip
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function LoginAndTickOut(array $memberInfo,string $token,string $ip)
    {
        if($memberInfo){

            $session = array(
                'uid'         => $memberInfo['id'],
                'username'    => $memberInfo['uname'],
                'session_key' => $token,
                'login_time'   => time(),
                'access_time'  => time(),
                'login_ip'     => $ip
            );

            $user  = AdminSession::new($session);
            $user->save();
            $insertId = $user->getId();
            if($insertId){
                $wheres   = [
                    'uid' => $memberInfo['id'],
                    ['id', '<', $insertId]
                ];
                $update = [
                    'is_online' => 0,
                    'state' => 1
                ];
                AdminSession::where($wheres)->update($update);

                $memberWheres = [
                    'id' => $memberInfo['id']
                ];
                $memberUpdate = [
                    'last_login_time' => time()

                ];
                if(empty($memberInfo['first_login_time'])){
                    $memberUpdate['first_login_time'] = time();
                }

                AdminMembers::where($memberWheres)->update($memberUpdate);
                AdminMembers::where($memberWheres)->increment('login_times',1);

            }
            return $insertId;
        }
        return null;
    }

}
