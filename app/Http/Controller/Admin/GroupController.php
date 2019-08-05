<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\MessageConstant;
use App\Http\Modules\GroupModules;
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
 * Class GroupController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class GroupController
{

    /**
     * @RequestMapping(route="/interface/groupList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function groupList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        if(!empty($where['username']) && $where['username']){
            if($userInfo = UserModules::getUserInfoByName($where['username'])){
                $where['owner_uid'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }
        $return = GroupModules::getGroupList($where,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }

    /**
     * @RequestMapping(route="/interface/groupUserList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function groupUserList(Request $request):Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        if(!empty($where['id'])){
            $return = GroupModules::getUserListByGroupID($where['id'],$data['page'],$data['limit']);
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'where'=>$data['data']]);
    }

}
