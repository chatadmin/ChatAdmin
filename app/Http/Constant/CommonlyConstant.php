<?php


namespace App\Http\Constant;


class CommonlyConstant
{

    const REDIS_ADMIN_VCODE = 'adminVcode';//验证码redis key
    const REDIS_ADMIN_VCODE_DB = 1;//验证码 redis db 库
    const REDIS_WECHAT_GROUP_BONUS_DB = 2;//群组红包 redis db 库
    const REDIS_WECHAT_GROUP_BONUS_KEY = "group_red_";//群组红包 redis KEY
    const REDIS_POOL_TWO = 'redis.pool.two';
    const REDIS_POOL_ONE = 'redis.pool.one';
    const MEMBERS_LOGIN_TOKEN_EXPIRED_TIME = 7200;//用户登陆后token过期时间
    const ADMIN_SESSION_COLUMN_IS_ONLINE = 1; //在线
    const ADMIN_SESSION_COLUMN_IS_ONLINE_OFF = 0;//下线
    const CHAT_USER_RECHARGE_STATUS_SINGLE_RECEIVE = 1;//个人红包领取
    const CHAT_USER_RECHARGE_STATUS_SINGLE_ISSUE = 2;//个人红包发放
    const CHAT_USER_RECHARGE_STATUS_GROUP_RECEIVE = 3;//群组红包发放
    const CHAT_USER_RECHARGE_STATUS_GROUP_ISSUE = 4;//群组红包发放
    const CHAT_USER_RECHARGE_STATUS_GROUP_RETURN = 5;//群组红包退还
    const CHAT_USER_RECHARGE_STATUS_SINGLE_RETURN = 6;//个人红包退还
    const CHAT_USER_RECHARGE_STATUS_ADMIN = 7;//后台账户充值
    const CHAT_USER_FRIEND_ADD_TO_ONE = 1;//主动添加好友
    const CHAT_USER_FRIEND_ADD_TO_TWO = 2;//被动添加好友
    const CHAT_USER_FRIEND_SOURCE_ONE = 1;//扫码添加
    const CHAT_USER_FRIEND_SOURCE_TWO = 2;//通过群聊
    const CHAT_USER_FRIEND_BLACK_TO_ONE = 1;//正常
    const CHAT_USER_FRIEND_BLACK_TO_TWO = 2;//被拉黑
    const CHAT_USER_FRIEND_STATUS_ONE = 1;//好友
    const CHAT_USER_FRIEND_STATUS_TWO = 2;//陌生人
    const CHAT_USER_FRIEND_STATUS_THREE = 3;//拉黑好友

    const CHAT_SINGLE_BONUS_STATUS_ONE = 1;//未领取
    const CHAT_SINGLE_BONUS_STATUS_TWO = 2;//已领取
    const CHAT_SINGLE_BONUS_STATUS_THREE = 3;//已退还

    const CHAT_GROUP_BONUS_STATUS_ONE = 1;//未领取
    const CHAT_GROUP_BONUS_STATUS_TWO = 2;//已退还
    const CHAT_GROUP_BONUS_STATUS_THREE = 3;//已领取
    const CHAT_CHAT_MESSAGE_SINGLE_TYPE = [
        5 =>"单聊文本消息",
        6 =>"单聊图片消息",
        7 => "单聊红包消息",
        17 => "单聊抢红包消息",
        15 => "单聊消息撤回",
        13 => "单聊添加好友消息",
        14 => "单聊同意添加好友",
        25 => "单聊名片消息"

    ];

    const CHAT_CHAT_MESSAGE_GROUP_TYPE = [
        8 => "群组文本消息",
        9 => "群组图片消息",
        10 => "群组红包消息",
        11 => "群组@类型消息",
        16 => "群组消息撤回",
        23 => "群组抢红包消息",
        24 => "群组名片消息"
    ];
}
