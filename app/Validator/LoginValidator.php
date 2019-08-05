<?php declare(strict_types=1);

namespace App\Validator;

use App\Http\Constant\CommonlyConstant;
use App\Http\Constant\MessageConstant;
use App\Http\Modules\AdminMembersModules;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Exception\ValidatorException;
use Swoft\Redis\Redis;

/**
 * Class LoginValidator
 *
 * @since 2.0
 *
 * @Validator(name="LoginValidator")
 */
class LoginValidator implements ValidatorInterface
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function validate(array $data, array $params): array
    {
        $uname = $data['username'] ?? '';
        $passwd = $data['password'] ?? '';
        $vcode = $data['vercode'] ?? '';
        $keyid = $data['keyid'] ?? '';

        if(strlen(trim($uname)) < 5){
            return ['code'=>MessageConstant::MESSAGE_VALIDATOR_USERNAME_LENTH_MIN_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_USERNAME_LENTH_MIN];
        }

        if(strlen(trim($uname)) > 30){
            return ['code'=>MessageConstant::MESSAGE_VALIDATOR_USERNAME_LENTH_MAX_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_USERNAME_LENTH_MAX];
        }

        if(strlen(trim($passwd)) < 1){
            return ['code'=>MessageConstant::MESSAGE_VALIDATOR_PASSWD_LENTH_MIN_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_PASSWD_LENTH_MIN];
        }

        if(strlen(trim($vcode)) !==4 ){

            return ['code'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_LENTH_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_LENTH];
        }

        if(!trim($keyid)){

            return ['code'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_KEYID_EMPTY_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_KEYID_EMPTY];
        }
        else{
            $redis = Redis::connection(CommonlyConstant::REDIS_POOL_ONE);
            $VcodeString = $redis->get($keyid);
            if($VcodeString){
                if(strtoupper($VcodeString) != strtoupper($vcode)){
                    return ['code'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_ERROR_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_ERROR];
                }
            }else{
                return ['code'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_EXPRIED_ERROR_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_EXPRIED_ERROR];
            }

        }

        $member = AdminMembersModules::checkMemberByUname($uname);
        $memberInfo = $member ?? null;
        if(!$member){
            return ['code'=>MessageConstant::MESSAGE_MEMBERS_NOT_EXIST_CODE,'message'=>MessageConstant::MESSAGE_MEMBERS_NOT_EXIST];
        }
        if (md5($passwd) != $member['passwd']) {
            return ['code' => MessageConstant::MESSAGE_MEMBERS_WRONG_PASSWD_CODE, 'message' => MessageConstant::MESSAGE_MEMBERS_WRONG_PASSWD];
        }

        return ['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'data'=>$data,'memberInfo'=>$memberInfo];
    }
}
