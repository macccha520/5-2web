<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use Overtrue\EasySms\EasySms;


    class Sms extends Base
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function send()
        {
            $config = [
                // HTTP 请求的超时时间（秒）
                'timeout' => 5.0,

                'default' => [
                    'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
                    'gateways' => [
                        'aliyun'
                    ],
                ],
                // 可用的网关配置
                'gateways' => [
                    'errorlog' => [
                        'file' => '/tmp/easy-sms.log',
                    ],
                    'aliyun' => [
                        'access_key_id' => '',
                        'access_key_secret' => '',
                        'sign_name' => '',
                    ],

                ],
            ];

            $easySms = new EasySms($config);

            $easySms->send(13188888888, [
                'content'  => '您的验证码为: 6379',
                'template' => 'SMS_001',
                'data' => [
                    'code' => 6379
                ],
            ]);
        }
    }
