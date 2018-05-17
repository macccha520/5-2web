<?php
    namespace app\exception;

    use think\Response;

    class JsonTo
    {
        protected $statusCode = 200;
        protected $header = [];
        protected $msg = 'SUECCESS';
        protected $options = [];

        public function __construct(array $data=[],$code=200)
        {
             return Response::create([
                'status_code'  =>  $this->statusCode,
                'code'         =>  config('httpCode.OPTION_SUECCESS'),
                'msg'          =>  $this->msg,
                'data'         =>  $data
            ], 'json', config('httpCode.OPTION_SUECCESS'), $this->header, $this->options)->send();
        }
    }