<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use Overtrue\EasySms\EasySms;

    class Sms extends Base
    {
        protected $NoCheckMethods = ['send'];
        public function __construct()
        {
            parent::__construct();
        }

        public function send()
        {
            $easySms = new EasySms(config('Sms'));

            $easySms->send(13188888888, [
                'content'  => '您的验证码为: 6379',
                'template' => 'SMS_001',
                'data' => [
                    'code' => 6379
                ],
            ]);
        }

    }
