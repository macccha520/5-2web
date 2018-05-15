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
            return $this->setJwtAuthCode();
        }

        //
        protected function PageJssdk()
        {
            return $this->app->jssdk->buildConfig(['onMenuShareQQ'],true);
        }


        private  function setJwtAuthCode()
        {
            // Configures the time that the token was issue (iat claim)
            $token = (new Builder())->setIssuedAt(time())
                    ->setNotBefore(time() + 60)
                    ->setExpiration(time() + 3600)
                    ->set('uid', 1)
                    ->set('nickname','maccha')
                    ->getToken();

            $data = [
                'Authorization' => (string) $token,
                'iat'           => $token->getClaim('iat'),
                'nbf'           => $token->getClaim('nbf'),
                'exp'           => $token->getClaim('exp'),
            ];

            return json([
                'code'  => config('httpCode.OPTION_SUECCESS'),
                'msg'   => 'SUECCESS',
                'data'  => array_merge([
                    'nickname'=>  'maccha',
                    'openid'  =>  'yafd909asxqsxsxxasxgga86sd6v',
                    'head_pic'=>  3123123
                ],$data)
            ],config('httpCode.OPTION_SUECCESS'), [])->send();
        }


        private function WechatUserScope(\think\Request $requests)
        {
            if( $requests->has('code') && strlen($requests->get('code')) > 0)
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
            $this->app->oauth->redirect()->send();
        }
    }
