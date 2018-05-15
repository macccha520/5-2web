<?php

    namespace app\vue\controller;

    use think\Controller;
    use think\Db;
    use think\Error;
    use think\Request;
    use think\Response;
    use Lcobucci\JWT\Parser;
    use Lcobucci\JWT\ValidationData;

    class Base extends Controller
    {
        protected $Uid;
        protected $Userinfo =  [];
        protected $Method;
        protected $AuthCode;
        protected $PostData = [];
        protected $GetData  = [];
        protected $NoCheckMethods = [];
        const authCode = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpYXQiOjE1MjU5NjI1MDQsIm5iZiI6MTUyNTk2MjU2NCwiZXhwIjoxNTI1OTY2MTA0LCJ1aWQiOjF9.';

        public function __construct()
        {
            parent::__construct();
            $this->Method =  strtolower(request()->action());
            $AuthCode = request()->header('AuthCode');
            $this->AuthCode = $AuthCode && strlen($AuthCode) >0 ? $AuthCode : self::authCode;
            $this->PostData = request()->post();
            $this->GetData  = request()->get();
            $this->JwtAuthCheck();
        }


        protected function jsonTo( $data,$header= [] )
        {
            return json([
                'code'  => config('httpCode.OPTION_SUECCESS'),
                'msg'   => 'SUECCESS',
                'data'  => $data
            ],config('httpCode.OPTION_SUECCESS'), $header)->send();
        }


        protected function jsonError( $data,$code='',$msg='',$header= [] )
        {
            $code = $code ? $code : config('httpCode.OPTION_FAIL');
            return json([
                'code'  => $code,
                'msg'   => $msg ? $msg : 'OPTION_FAIL',
                'data'  => $data
            ],$code, $header)->send();
        }


        public function JwtAuthCheck()
        {
            if(! in_array( $this->Method, $this->NoCheckMethods) ) {
                if( false === $this->JwtAuthCode() ) {
                    $this->jsonError([],config('httpCode.Unauthorized'),'Unauthorized');
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
