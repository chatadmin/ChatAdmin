<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\MessageConstant;
use App\Http\Modules\AdminMembersModules;
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
 * Class UserController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class UserController
{

    /**
     * @RequestMapping(route="/interface/userinfo",method={RequestMethod::GET})
     * @param Request $request
     * @return Response
     */
    function userinfo(Request $request): Response
    {
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'data'=>$request->user]);
    }

    /**
     * @RequestMapping(route="/interface/logout",method={RequestMethod::GET})
     * @param Request $request
     * @return Response
     */
    function logout(Request $request):Response
    {
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_LOGIN_FALID_CODE]);
    }

    /**
     * @RequestMapping(route="/interface/userlist",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws
     */
    function userlist(Request $request):Response
    {
        $data = $request->getParsedBody();
        $return = UserModules::getUserList($data['where'],$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);

    }

    /**
     * @RequestMapping(route="/interface/switchUserStatus",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function switchUserStatus(Request $request):Response
    {
        $data = $request->getParsedBody();
        $where['id'] = $data['id'];
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        $param['is_normal'] = $data['status'] ? 0 : 1;
        if(count($idArr) > 1){
            $where['whereIn']['values'] = $idArr;
            $where['whereIn']['column'] = 'id';
        }elseif($count==1 && $idArr[0]){
            $where['where'] = ['id' => $idArr[0]];
            $userInfo = UserModules::getUserInfoByID($idArr[0]);
            if(!empty($userInfo) && isset($userInfo['isNormal']))
            {
                $param['is_normal'] = $userInfo['isNormal'] ? 0 : 1;
            }
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }

        if(UserModules::Update($where,$param)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);
    }

    /**
     * @RequestMapping(route="/interface/editPassword",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function editPassword(Request $request):Response
    {
        $data = $request->getParsedBody();
        if(empty($data['pwd']) || empty($data['pwdconf'])){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_NOT_EMPTY_CODE,'message'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_NOT_EMPTY]);
        }

        if($data['pwd'] != $data['pwdconf']){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_NOT_SAME_CODE,'message'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_NOT_SAME]);
        }

        $where['id'] = $request->user['id'];
        $param['passwd'] = md5($data['pwd']);

        if(AdminMembersModules::update($where,$param)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_EDIT_SUCCESS]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_EDIT_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_MEMBERS_PASSWD_EDIT_FAILURE]);
    }


    /**
     * 用户充值
     * @RequestMapping(route="/interface/recharge",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public function recharge(Request $request):Response
    {
        $data = $request->getParsedBody();
        if(!empty($data['id']) && (float)$data['money'] > 0){
            $id = (int)$data['id'];
            $money = (float)$data['money'];
            if($info = UserModules::recharge($id,$money)){
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_SUCCESS,'money'=>sprintf('%.2f',$info['wallet'])]);
            }
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_FAILURE]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_VALIDATOR_VCODE_KEYID_EMPTY]);
    }

    /**
     * 获取用户信息
     * @RequestMapping(route="/interface/getUserInfo",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getUserInfo(Request $request):Response
    {
        $data = $request->getParsedBody();
        if(empty($data['data']['id'])){
           return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_SUCCESS]);
        }
        $userInfo = UserModules::getUserInfoByID($data['data']['id']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_SUCCESS,'userInfo'=>$userInfo]);
    }
}
