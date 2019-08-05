<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\MessageConstant;
use App\Http\Modules\BonusModules;
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
 * Class BonusController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class BonusController
{

    /**
     * @RequestMapping(route="/interface/singleBonusList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function singleList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        $nwhere = [];
        if(!empty($where['send_uid']) && $where['send_uid']){
            $nwhere['id'] = $where['send_uid'];
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
        $nwhere['status'] = $where['status'] ?? null;
        $nwhere['fromtime'] = $where['fromtime'] ?? '';
        $nwhere['totime'] = $where['totime'] ?? '';
        $return = BonusModules::getSingleBonusList($nwhere,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }

    /**
     * 个人红包退还
     * @RequestMapping(route="/interface/singleBonusBack",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */

    public function singleBonusBack(Request $request): Response
    {
        $data = $request->getParsedBody();
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        if($count > 1){
            $where['ids'] = $idArr;
        }elseif($count == 1 && $idArr[0]){
            $where['ids'] = [$idArr[0]];
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }

        if(BonusModules::singleBonusBack($where)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);
    }


    /**
     * 群组红包退还
     * @RequestMapping(route="/interface/groupBonusBack",method={RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */

    public function groupBonusBack(Request $request): Response
    {
        $data = $request->getParsedBody();
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        if($count > 1){
            $where['ids'] = $idArr;
        }elseif($count == 1 && $idArr[0]){
            $where['ids'] = [$idArr[0]];
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }

        if(BonusModules::groupBonusBack($where)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);
    }

    /**
     * 获取群组红表列表
     * @RequestMapping(route="/interface/groupBonusList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function groupBonusList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        $nwhere = [];
        if(!empty($where['send_uid']) && $where['send_uid']){
            $nwhere['id'] = $where['send_uid'];
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

        if(!empty($where['group_name']) ){
            $groupInfo = GroupModules::getGroupInfoByName($where['group_name']);
            if(!empty($groupInfo)){
                $nwhere['group_id'] = $groupInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }

        $nwhere['status'] = $where['status'] ?? null;

        $nwhere['fromtime'] = $where['fromtime'] ?? '';
        $nwhere['totime'] = $where['totime'] ?? '';
        $return = BonusModules::getGroupBonusList($nwhere,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }


    /**
     * @RequestMapping(route="/interface/groupBonusDetails",method={RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function groupBonusDetails(Request $request):Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        if(!empty($where['id'])){
            $return = BonusModules::getDetailsListByGroupID($where['id'],$data['page'],$data['limit']);
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'where'=>$data['data']]);
    }
}
