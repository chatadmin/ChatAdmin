<?php declare(strict_types=1);


namespace App\Http\Middleware;
use App\Http\Constant\CommonlyConstant;
use App\Http\Constant\MessageConstant;
use App\Http\Modules\AdminMembersModules;
use App\Http\Modules\AdminSessionModules;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Context\Context;

/**
 * Class TokenMiddleware
 * @Bean()
 */

class TokenMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('token');
        $serverInfo = $request->getServerParams();
        if($serverInfo['request_uri']=='/interface/logout'){
            $request->user = null;
            return $response = Context::mustGet()->getResponse()->withData(array('code'=>MessageConstant::MESSAGE_LOGIN_FALID_CODE,'message'=>MessageConstant::MESSAGE_LOGOUT_SUCCESS));
        }
        if(!empty($token)){
            $accessTime = CommonlyConstant::MEMBERS_LOGIN_TOKEN_EXPIRED_TIME; //登录超时时长
            $time       = intval(time()) - $accessTime;
            $session = AdminSessionModules::getOneByWhere(['session_key'=>$token,'is_online'=>CommonlyConstant::ADMIN_SESSION_COLUMN_IS_ONLINE,['access_time','>=',$time]]);
            //验证当前是否登录中
            if (!empty($session)) {
                //更新最后操作时间
                AdminSessionModules::updateSession($session['id']);
                $userInfo = AdminMembersModules::checkMemberById($session['uid']);
                if(empty($userInfo)){
                    return $response = Context::mustGet()->getResponse()->withData(array('code'=>MessageConstant::MESSAGE_LOGIN_FALID_CODE,'message'=>MessageConstant::MESSAGE_LOGIN_EXPIRED));
                }
                $request->user['id'] = $userInfo['id'];
                $request->user['uname'] = $userInfo['uname'];
                $request->user['lastLoginTime'] = date('Y-m-d H:i:s',$userInfo['lastLoginTime']);
                $request->user['lastLoginTime'] = date('Y-m-d H:i:s',$userInfo['lastLoginTime']);
                $request->user['status']  = $userInfo['status'];

            } else {
                return $response = Context::mustGet()->getResponse()->withData(array('code'=>MessageConstant::MESSAGE_LOGIN_FALID_CODE,'message'=>MessageConstant::MESSAGE_LOGIN_EXPIRED));
            }
        }else{
            return $response = Context::mustGet()->getResponse()->withData(array('code'=>MessageConstant::MESSAGE_LOGIN_FALID_CODE,'message'=>MessageConstant::MESSAGE_LOGIN_EXPIRED));
        }

        return $handler->handle($request);
    }

}
