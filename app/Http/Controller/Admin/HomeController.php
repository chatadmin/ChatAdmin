<?php declare(strict_types=1);

namespace App\Http\Controller\Admin;

use App\Http\Constant\CommonlyConstant;
use App\Http\Constant\MessageConstant;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Context\Context;
use App\Http\Library\FunctionsClass;
use App\Http\Library\Image;
use Swoft\Redis\Redis;
use Swoft\Validator\Annotation\Mapping\Validate;
use App\Http\Modules\AdminSessionModules;

/**
 * Class HomeController
 * @Controller()
 * @package App\Http\Controller\Admin
 */
class HomeController
{

    /**
     * @RequestMapping(route="/interface/login",method={RequestMethod::POST})
     * @Validate(validator="LoginValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function login(Request $request): Response
    {
        $serversInfo = $request->getServerParams();
        $ip = $serversInfo['remote_addr'];
        $post = $request->getParsedBody();
        if(isset($post['memberInfo']) && $post['memberInfo']){

            $token = FunctionsClass::Settoken();
            $insertId = AdminSessionModules::LoginAndTickOut($post['memberInfo'],$token,$ip);
            if($insertId){
                $result                 = array();
                $result['uid']          = $post['memberInfo']['id'];
                $result['username']     = $post['memberInfo']['uname'];
                $result['token'] = $token;
                $post = [
                    'code' => MessageConstant::MESSAGE_SUCCESS_CODE,
                    'message' => MessageConstant::MESSAGE_LOGIN_SUCCESS,
                    'data' => $result
                ];
            }else{
                $post = [
                    'code' => MessageConstant::MESSAGE_LOGIN_FAILURE_CODE,
                    'message' => MessageConstant::MESSAGE_LOGIN_FAILURE
                ];
            }

        }
        return Context::mustGet()->getResponse()->withData($post);

    }

    /**
     * @RequestMapping("/interface/vcode",method={RequestMethod::GET,RequestMethod::POST})
     * @return Response
     * @throws \Swoft\Redis\Exception\RedisException
     */
    public function vcode(): Response
    {
        $key = FunctionsClass::MakeKey();
        $image = new Image();
        $image->LImageCreate();
        $image->LImagecolorallocate();
        ob_start();
        $info = $image->LImagePNG();
        $redis = Redis::connection(CommonlyConstant::REDIS_POOL_ONE);
        $redis->setex($key,60 ,$info['code']);
        $image_data = ob_get_contents();//生成png格式
        $image->LImageDestroy();
        ob_end_clean();
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'url'=>base64_encode($image_data),'info'=>$info,'key'=>$key]);
    }

}
