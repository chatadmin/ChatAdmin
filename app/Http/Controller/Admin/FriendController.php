<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\MessageConstant;
use App\Http\Modules\FriendModules;
use App\Http\Modules\UserModules;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Context\Context;
use App\Http\Middleware\TokenMiddleware;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class FriendController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class FriendController
{

    /**
     * @RequestMapping(route="/interface/friendList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function friendList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $nwhere = [];
        $where = $data['where'];
        if(!empty($where['id']) && $where['id']){
            $nwhere['id'] = $where['id'];
        }else if(!empty($where['username']) && $where['username']){
            if($userInfo = UserModules::getUserInfoByName($where['username'])){
                $nwhere['id'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }else if(!empty($where['phone']) && $where['phone']){
            if($userInfo = UserModules::getUserInfoByPhone($where['phone'])){
                $nwhere['id'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }
        $return = FriendModules::getFriendList($nwhere,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }


}
