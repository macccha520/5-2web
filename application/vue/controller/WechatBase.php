<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Request;
    use EasyWeChat\Factory;
    use Lcobucci\JWT\Builder;

    class WechatBase extends controller
    {
        protected $app;
        protected static $config = [
            'app_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        public function __construct()
        {
            parent::__construct();
            $this->app = Factory::officialAccount( self::$config );
        }

        //
        public function WechatUserScope ()
        {
            $oauth = $this->app->oauth;
            $user = $oauth->user();

            $token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
                    ->setAudience('http://example.org') // Configures the audience (aud claim)
                    ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                    ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                    ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
                    ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                    ->set('uid', 1) // Configures a new claim, called "uid"
                    ->getToken(); // Retrieves the generated token


            $token->getHeaders(); // Retrieves the token headers
            $token->getClaims(); // Retrieves the token claims

            echo $token->getHeader('jti'); // will print "4f1g23a12aa"
            echo $token->getClaim('iss'); // will print "http://example.com"
            echo $token->getClaim('uid'); // will print "1"
            echo $token; //
        }

        //
        protected function PageJssdk()
        {
            echo $this->app->jssdk->buildConfig(['onMenuShareQQ'],true);
        }


    }
