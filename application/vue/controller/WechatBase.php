<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use EasyWeChat\Factory;
    use Lcobucci\JWT\Builder;

    class WechatBase extends controller
    {
        protected $app;

        public function __construct()
        {
            parent::__construct();
            $this->app = Factory::officialAccount( config('wechat.oauth') );
        }

        //
        public function WechatUserinfo ()
        {
            return json([
                'code'  => config('httpCode.OPTION_SUECCESS'),
                'msg'   => 'SUECCESS',
                'data'  => [
                    'AuthCode'=>  $this->setJwtAuthCode(),
                    'nickname'=>  12312,
                    'openid'  =>  'qweqweuqwue',
                    'head_pic'=>  3123123
                ]
            ],config('httpCode.OPTION_SUECCESS'), [])->send();
        }

        //
        protected function PageJssdk()
        {
            $this->app->jssdk->buildConfig(['onMenuShareQQ'],true);
        }


        private  function setJwtAuthCode()
        {
            // Configures the time that the token was issue (iat claim)
            $token = (new Builder())->setIssuedAt(time())
                    ->setNotBefore(time() + 60)
                    ->setExpiration(time() + 3600)
                    ->set('uid', 1)
                    ->getToken();

            return (string) $token;
        }


        private function WechatUserScope()
        {
             $oauth = $this->app->oauth;
             $user = $oauth->user();
             $user->getId();  // 对应微信的 OPENID
             $user->getNickname(); // 对应微信的 nickname
             $user->getName(); // 对应微信的 nickname
             $user->getAvatar(); // 头像网址
             $user->getOriginal(); // 原始API返回的结果
             $user->getToken(); // access_token， 比如用于地址共享时使用
        }
    }
