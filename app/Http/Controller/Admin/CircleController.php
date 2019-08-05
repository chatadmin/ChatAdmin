<?php


namespace App\Http\Controller\Admin;

use App\Http\Constant\MessageConstant;
use App\Http\Modules\CircleModules;
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
 * Class CircleController
 * @Controller()
 * @Middleware(TokenMiddleware::class)
 * @package App\Http\Controller\Admin
 */
class CircleController
{

    /**
     * @RequestMapping(route="/interface/circleList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    function circleList(Request $request): Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        if(!empty($where['id'])){
            $where['id'] = $where['id'];
        }else if(!empty($where['username'])){
            if($userInfo = UserModules::getUserInfoByName($where['username'])){
                $where['id'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }else if(!empty($where['phone'])){
            if($userInfo = UserModules::getUserInfoByPhone($where['phone'])){
                $where['id'] = $userInfo['id'];
            }else{
                return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'data'=>[],'where'=>$data['data']]);
            }
        }

        $return = CircleModules::getCircleList($where,$data['page'],$data['limit']);
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
    }

    /**
     * @RequestMapping(route="/interface/cirdel",method={RequestMethod::GET,RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public function cirdel(Request $request):Response
    {
        $data = $request->getParsedBody();
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        if($count > 0){
            foreach ($idArr as $key=>$value){
                if(empty($value)){
                    unset($idArr[$key]);
                }
            }
            $where['ids'] = $idArr;
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }

        if(CircleModules::CircleDelete($where)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);
    }

    /**
     * @RequestMapping(route="/interface/likeList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function likeList(Request $request):Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        if(!empty($where['id'])){
            $return = CircleModules::getUserListForLikeByCircleID((int)$where['id'],$data['page'],$data['limit']);
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'where'=>$data['data']]);
    }


    /**
     * @RequestMapping(route="/interface/commentList",method={RequestMethod::GET,RequestMethod::POST})
     * @Validate(validator="DataDealwithValidator")
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function commentList(Request $request):Response
    {
        $data = $request->getParsedBody();
        $where = $data['where'];
        if(!empty($where['id'])){
            $return = CircleModules::getUserListForCommentByCircleID((int)$where['id'],$data['page'],$data['limit']);
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>$return['count'],'data'=>$return['list'],'where'=>$data['data']]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'count'=>0,'where'=>$data['data']]);
    }

    /**
     * 评论删除
     * @RequestMapping(route="/interface/commentDelete",method={RequestMethod::GET,RequestMethod::POST})
     * @param Request $request
     * @return Response
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Throwable
     */
    public function commentDelete(Request $request):Response
    {

        $data = $request->getParsedBody();
        $idArr = explode('|', $data['id']);
        $count = count($idArr);
        if($count > 0){
            foreach ($idArr as $key=>$value){
                if(empty($value)){
                    unset($idArr[$key]);
                }
            }
            $where['ids'] = $idArr;
        }else{
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX_CODE,'message'=>MessageConstant::MESSAGE_USER_SELECTED_CHECKBOX]);
        }
        if(CircleModules::CommentDelete($where)){
            return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_SUCCESS_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_SETTING]);
        }
        return Context::mustGet()->getResponse()->withData(['code'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE_CODE,'message'=>MessageConstant::MESSAGE_USER_STATUS_IS_FAILURE]);
    }

}
