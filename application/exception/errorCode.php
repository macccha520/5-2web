<?php

return [
    'SYSTEM_FAILED'                    => [
        'code' => 1000,
        'msg'  => '系统繁忙',
    ],
    'LOGIN_FAILED'                     => [
        'code' => 1001,
        'msg'  => '用户名或密码错误',
    ],
    'USER_NOT_EXIST'                   => [
        'code' => 1002,
        'msg'  => '用户不存在',
    ],
    'FAILED_TOO_MANY'                  => [
        'code' => 1003,
        'msg'  => '登录失败次数太多，请稍后再试',
    ],
    'OPTIONS_FAILED'                   => [
        'code' => 1004,
        'msg'  => '操作失败',
    ],
    'STORE_NOT_EXIST'                  => [
        'code' => 1005,
        'msg'  => '门店不存在',
    ],
    'PERMISSION_CHILD_ROLES'           => [
        'code' => 1006,
        'msg'  => '请先将该权限的子权限删除后再做删除操作',
    ],
    'PROMOTION_HAS_DOING'              => [
        'code' => 1007,
        'msg'  => '有进行中的优惠活动，不能添加！',
    ],
    'ROLE_NOT_EXIST'                   => [
        'code' => 1008,
        'msg'  => '找不到该角色',
    ],
    'IS_NOT_SUPER'                     => [
        'code' => 1009,
        'msg'  => '你不是管理员',
    ],
    'PERMISSION_NOT_EXIST'             => [
        'code' => 1010,
        'msg'  => '找不到该权限',
    ],
    'MOBILE_IS_EXIST'                  => [
        'code' => 1011,
        'msg'  => '手机号码已存在！',
    ],
    'USERSNAME_IS_EXIST'               => [
        'code' => 1012,
        'msg'  => '名字已存在！',
    ],
    'OPENID_NOT_EXIST' => [
        'code' => 1013,
        'msg'  => 'openid不存在'
    ],
    'IS_NOT_WECHAT' => [
        'code' => 1014,
        'msg'  => '请在微信环境内运行'
    ],
    'WECHAT_RESPONSE_EMPTY' => [
        'code' => 1015,
        'msg'  => '微信http请求返回为空！操作失败'
    ],
    'WECHAT_RETURN_ERROR' => [
        'code' => 1016,
        'msg'  => '微信返回错误'
    ],
    'WECHAT_REQUEST_ERROR' => [
        'code' => 1017,
        'msg'  => '请求微信接口失败'
    ],
    'WECHAT_GET_TICKET_ERROR' => [
        'code' => 1018,
        'msg'  => '获取微信ticket失败'
    ],
    'WECHAT_GET_TOKEN_ERROR' => [
        'code' => 1019,
        'msg'  => '获取微信token失败'
    ],
    'TOKEN_NOT_EXIST' => [
        'code' => 1020,
        'msg'  => '获取Authorization失败'
    ],
    'COUPON_NOT_FOUND' => [
        'code' => 1021,
        'msg'  => '找不到优惠券'
    ],
    'COUPON_TIME_IS_OVER' => [
        'code' => 1021,
        'msg'  => '抱歉，已经过了领取时间'
    ],
    'COUPON_SEND_IS_OVER' => [
        'code' => 1022,
        'msg'  => '来晚了，优惠券被抢完了'
    ],
    'COUPON_RECIEVED' => [
        'code' => 1023,
        'msg'  => '您已领取过该优惠券'
    ],
    'COUPON_INVALID' => [
        'code' => 1024,
        'msg'  => '优惠券不可用'
    ],
    'MOBILE_INVALID' => [
        'code' => 1025,
        'msg'  => '手机号不正确'
    ],
    'SMS_IN_TIME' => [
        'code' => 1026,
        'msg'  => '短信发送太频繁'
    ],
    'SMS_CODE_INVALID' => [
        'code' => 1027,
        'msg'  => '短信验证失败'
    ],
    'DISTRIBUT_INVALID' => [
        'code' => 1028,
        'msg'  => '请填写个人信息等待审核'
    ],
    'DISTRIBUT_NOT_PASSED' => [
        'code' => 1029,
        'msg'  => '正在审核中'
    ],
    'MOBILE_NEED_SET' => [
        'code' => 1030,
        'msg'  => '请设置手机号'
    ],
    'NEW_USER_ONLY' => [
        'code' => 1031,
        'msg'  => '此商品新人专享'
    ],
    'SMS_RATE_LIMIT' => [
        'code' => 1032,
        'msg'  => '超过一天最大发送次数,请明天再试'
    ],
    'MUST_ONE_ADDRESS' => [
        'code' => 1033,
        'msg'  => '最少保留一个地址'
    ],
];
