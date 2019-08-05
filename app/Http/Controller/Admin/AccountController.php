<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\MessageConstant;
use App\Http\Modules\AccountModules;
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
 * Class AccountController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class AccountController
{

    /**
     * @RequestMapping(route="/interface/accountList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function accountList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $nwhere = [];
        $where = $data['where'];
        if(!empty($where['id']) && $where['id']){
            $nwhere['id'] = $where['id'];
        }else if(!empty($where['username'])){
            if($userInfo = UserModules::getUserInfoByName($where['username'])){
                $nwhere['id'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }else if(!empty($where['phone']) ){
            if($userInfo = UserModules::getUserInfoByPhone($where['phone'])){
                $nwhere['id'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }
        if(!empty($where['group_name']) ){
            $groupInfo = GroupModules::getGroupInfoByName($where['group_name']);
            if(!empty($groupInfo)){
                $nwhere['group_id'] = $groupInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }
        $nwhere['fromtime'] = $where['fromtime'] ?? '';
        $nwhere['totime'] = $where['totime'] ?? '';
        $return = AccountModules::getAccountList($nwhere,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }

}
