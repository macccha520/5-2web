<?php

namespace app\exception;


use Throwable;
use Think\Config;


class JsonError extends \Exception
{
    private $_isLog = false;
    private $_data = [];

    public $statusCode = 422;


    public function __construct($statusCode = 422, $errCode = 'SYSTEM_FAILED', $message = '',$header= [])
    {
        Config::load(APP_PATH . 'exception/errorCode'.EXT, 'errorCode', '_err_');
        $config  = config("errorCode.{$errCode}", null, '_err_');
        $this->code = isset($config['code']) ? $config['code'] : 1;
        $this->message = empty($message) && isset($config['msg']) ? $config['msg'] : $message;
        $this->statusCode = $statusCode;
    }

    public function setLog()
    {
        $this->_isLog = true;
        return $this;
    }


    public function isLog()
    {
        return $this->_isLog;
    }


    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }


    public function getData()
    {
        return $this->_data;
    }


    public function getStatusCode()
    {
        return $this->statusCode;
    }
}

