<?php

    namespace app\vue\controller;

    use think\Db;
    use app\exception\JsonError;
    use think\Request;
    use think\Response;
    use Lcobucci\JWT\Parser;
    use Lcobucci\JWT\ValidationData;
    use app\exception\JsonTo;

    class Base
    {
        protected $Uid;
        protected $Userinfo =  [];
        protected $Method;
        protected $AuthCode;
        protected $PostData = [];
        protected $GetData  = [];
        protected $NoCheckMethods = ['jsonTo'];
        const authCode = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpYXQiOjE1MjU5NjI1MDQsIm5iZiI6MTUyNTk2MjU2NCwiZXhwIjoxNTI1OTY2MTA0LCJ1aWQiOjF9.';

        public function __construct()
        {
            $this->Method =  strtolower(request()->action());
            $AuthCode = request()->header('AuthCode');
            $this->AuthCode = $AuthCode && strlen($AuthCode) >0 ? $AuthCode : self::authCode;
            $this->PostData = request()->post();
            $this->GetData  = request()->get();
            $this->JwtAuthCheck();
        }


        protected function jsonTo( array $data)
        {
            return new JsonTo($data);
        }


        protected function JwtAuthCheck()
        {
            if(! in_array( $this->Method, $this->NoCheckMethods) ) {
                if( false === $this->JwtAuthCode() ) {
                    throw new JsonError(422, 'TOKEN_NOT_EXIST');
                }
            }
        }


        private function JwtAuthCode()
        {
            // Parses from a string
            $token = (new Parser())->parse((string) $this->AuthCode);
            $checkUid = $token->getClaim('uid');

            $data = new ValidationData();
            $data->setId( $checkUid );

            if( true === $token->validate($data) ) {
                $this->Uid = $checkUid;
                $this->setUserInfo();
                return true;
            }
            return false;
        }


        private function setUserInfo()
        {
            $this->Userinfo = Db::name('users')->find($this->Uid);  
        }
    }
