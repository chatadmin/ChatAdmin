<?php


namespace App\Http\Library;



use App\Http\Constant\CommonlyConstant;

class FunctionsClass
{

    /**
     * @return string
     */
    static function MakeKey():string
    {

        return CommonlyConstant::REDIS_ADMIN_VCODE.substr(md5(time().rand(1,100000)),0,16);

    }

    /**
     * @return string
     */
    static function Settoken():string
    {

        $str = md5(uniqid(md5(microtime(true)), true));
        $str = sha1($str);
        return $str;

    }


}