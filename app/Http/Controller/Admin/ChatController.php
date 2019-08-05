<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\CommonlyConstant;
use App\Http\Constant\MessageConstant;
use App\Http\Modules\BonusModules;
use App\Http\Modules\ChatModules;
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
 * Class ChatController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class ChatController
{

    /**
     * @RequestMapping(route="/interface/singleChatList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function singleChatList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        $nwhere = [];
        if(!empty($where['sent_uid']) && $where['sent_uid']){
            $nwhere['sent_uid'] = $where['sent_uid'];
        }else if(!empty($where['sent_username'])){
            if($userInfo = UserModules::getUserInfoByName($where['sent_username'])){
                $nwhere['sent_uid'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }else if(!empty($where['sent_phone'])){
            if($userInfo = UserModules::getUserInfoByPhone($where['sent_phone'])){
                $nwhere['sent_uid'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }

        if(!empty($where['accept_uid']) && $where['accept_uid']){
            $nwhere['accept_uid'] = $where['accept_uid'];
        }else if(!empty($where['accept_username'])){
            if($userInfo = UserModules::getUserInfoByName($where['accept_username'])){
                $nwhere['accept_uid'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }else if(!empty($where['accept_phone'])){
            if($userInfo = UserModules::getUserInfoByPhone($where['accept_phone'])){
                $nwhere['accept_uid'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }

        $nwhere['fromtime'] = $where['fromtime'] ?? '';
        $nwhere['single_type'] = $where['single_type'] ?? '';
        $nwhere['totime'] = $where['totime'] ?? '';
        $return = ChatModules::getSingleChatList($nwhere,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }

    /**
     * 获取类型
     * @RequestMapping(route="/interface/getSingleType",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */

    public function getSingleType(Request $request): Response
    {
        $type = CommonlyConstant::CHAT_CHAT_MESSAGE_SINGLE_TYPE;
        if(empty($type)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_FAILURE]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_SUCCESS,'data'=>$type]);
    }

    /**
     * @RequestMapping(route="/interface/singleChatDelete",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public function singleChatDelete(Request $request):Response
    {
        $data = $request->getParsedBody();
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        if($count > 1){
            $where['ids'] = $idArr;
        }elseif($count == 1 && $idArr[0]){
            $where['ids'] = $idArr;
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }

        if(ChatModules::singleChatDelete($where)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);

    }

    /**
     * @RequestMapping(route="/interface/groupChatList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function groupChatList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        $nwhere = [];
        if(!empty($where['sent_uid']) && $where['sent_uid']){
            $nwhere['sent_uid'] = $where['sent_uid'];
        }else if(!empty($where['sent_username'])){
            if($userInfo = UserModules::getUserInfoByName($where['sent_username'])){
                $nwhere['sent_uid'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }else if(!empty($where['sent_phone'])){
            if($userInfo = UserModules::getUserInfoByPhone($where['sent_phone'])){
                $nwhere['sent_uid'] = $userInfo['id'];
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
        $nwhere['group_type'] = $where['group_type'] ?? '';
        $nwhere['totime'] = $where['totime'] ?? '';
        $return = ChatModules::getGroupChatList($nwhere,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }

    /**
     * 获取类型
     * @RequestMapping(route="/interface/getGroupType",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */

    public function getGroupType(Request $request): Response
    {
        $type = CommonlyConstant::CHAT_CHAT_MESSAGE_GROUP_TYPE;
        if(empty($type)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_FAILURE]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_SUCCESS,'data'=>$type]);
    }

    /**
     * @RequestMapping(route="/interface/groupChatDelete",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public function groupChatDelete(Request $request):Response
    {
        $data = $request->getParsedBody();
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        if($count > 1){
            $where['ids'] = $idArr;
        }elseif($count == 1 && $idArr[0]){
            $where['ids'] = $idArr;
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }

        if(ChatModules::groupChatDelete($where)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);

    }


}
