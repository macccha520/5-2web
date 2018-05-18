<?php

    namespace app\vue\controller;

    use think\Request;
    use think\Db;
    use EasyWeChat\Factory;
    use Lcobucci\JWT\Builder;
    use app\exception\JsonTo;

    class WechatBase
    {
        protected $app;

        public function __construct()
        {
            $this->app = Factory::officialAccount( config('wechat.oauth') );
        }


        public function WechatUserinfo ()
        {
            return $this->WechatUserScope();
        }


        protected function PageJssdk()
        {
            return $this->app->jssdk->buildConfig(['onMenuShareQQ'],true);
        }


        private function WechatUserScope()
        {
            if( request()->has('code')
                && strlen( request()->get('code')) > 0)
            {
                file_put_contents('1.txt','-------'.PHP_EOL);
                file_put_contents('1.txt',var_export(request()->get('code'),true));
                file_put_contents('1.txt','-------'.PHP_EOL);
            }else{
                return $this->app->oauth->redirect()->send();
            }
        }


        protected function UserScope()
        {
            $oauth = $this->app->oauth;
            $user = $oauth->user();
            $userinfo = $user->getOriginal();

            file_put_contents('1.txt','-------'.PHP_EOL);
            file_put_contents('1.txt',var_export($userinfo,true));
            file_put_contents('1.txt','-------'.PHP_EOL);

           // return $this->setJwtAuthCode( $this->loginOrReg($userinfo) );

            //$user->getId();  // 对应微信的 OPENID
//                $user->getNickname(); // 对应微信的 nickname
//                $user->getName(); // 对应微信的 nickname
//                $user->getAvatar(); // 头像网址
//                $user->getOriginal(); // 原始API返回的结果
//                $user->getToken(); // access_token， 比如用于地址共享时使用
        }


        protected function loginOrReg($userInfo)
        {
            $now = time();
            $oauth = 'weixin';
            $user = get_user_info($userInfo['openid'], 3, $oauth);
            $map['last_login'] = $now;
            if (!$user) {
                //账户不存在 注册一个
                $map['password'] = '';
                $map['openid'] = $userInfo['openid'];
                $map['nickname'] = !empty($userInfo['nickname']) ? $userInfo['nickname'] : '匿名网友';
                $map['reg_time'] = $now;
                $map['oauth'] = $oauth;
                $map['head_pic'] = !empty($userInfo['headimgurl']) ? $userInfo['headimgurl'] : '';
                $map['sex'] = empty($userInfo['sex']) ? 0 : $userInfo['sex'];
                $map['first_leader'] = !empty($_GET['first_leader']) ? $_GET['first_leader'] : 0;
                // 微信授权登录返回时 get 带着参数的
                $userId = Db::name('users')->insertGetId($map);
                $user = array_merge($map,[
                    'id' => $userId,
                ]);

            }else{
                if ((!$user['nickname'] || $user['nickname'] == '匿名网友' || !$user['head_pic']))
                {
                    $subscribe = !empty($userInfo['subscribe'])?$userInfo['subscribe']:0;
                    if ($subscribe) {
                        $user['nickname'] = $userInfo['nickname'];
                        $user['head_pic'] = $userInfo['headimgurl'];
                        $user['sex'] = $userInfo['sex'];
                    }
                    $map['nickname'] = !empty($user['nickname'])?$user['nickname']:'匿名网友';
                    $map['head_pic'] = !empty($user['head_pic'])?$user['head_pic']:'';
                    $map['sex']      = empty($user['sex']) ? 0 : $user['sex'];
                    Db::name('users')->where("user_id", $user['user_id'])->save($map);
                    $user = array_merge($map, [
                        'openid' => $userInfo['openid'],
                        'oauth'  => $oauth,
                        'id'     => $user['user_id'],
                    ]);
                }
            }
            return $user;
        }


        protected  function setJwtAuthCode($user)
        {
            // Configures the time that the token was issue (iat claim)
            $token = (new Builder())->setIssuedAt(time())
                ->setNotBefore(time() + 60)
                ->setExpiration(time() + 3600)
                //->set('id', $user['user_id'])
                //->set('nickname',$user['nickname'])
                ->getToken();

            $data = [
                'Authorization' => (string) $token,
                'iat'           => $token->getClaim('iat'),
                'nbf'           => $token->getClaim('nbf'),
                'exp'           => $token->getClaim('exp'),
            ];

           return new JsonTo(array_merge([
                //'nickname'=>  $user['nickname'],
                //'openid'  =>  $user['openid'],
                //'head_pic'=>  $user['head_pic']
            ],$data));
        }
    }
