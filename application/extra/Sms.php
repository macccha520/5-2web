<?php

    return [
        // HTTP 请求的超时时间（秒）
        'timeout' => 5.0,

        'default' => [
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
            'gateways' => ['aliyun'],
        ],
        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => '/sms.log',
            ],
            'aliyun' => [
                'access_key_id' => '',
                'access_key_secret' => '',
                'sign_name' => '',
            ],
        ],
    ];