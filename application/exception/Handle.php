<?php
namespace app\exception;

use Exception;
use think\exception\Handle as baseHandle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\exception\ClassNotFoundException;
use think\exception\RouteNotFoundException;
use think\exception\TemplateNotFoundException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;

class Handle extends baseHandle
{
    protected $ignoreReport = [
        '\\think\\exception\\HttpException',
    ];

    public function render(Exception $e)
    {
        $msg        = $e->getMessage();
        $data       = [];
        $code       = 1;
        $statusCode = 500;
        switch ($e) {
            case $e instanceof JsonError:
                $data = $e->getData();
                $code = $e->getCode();
                break;

            case $e instanceof ValidateException:
                $statusCode = 422;
                $code       = 1004;
                break;
            case $e instanceof HttpException:
            case $e instanceof ModelNotFoundException:
            case $e instanceof DataNotFoundException:
            case $e instanceof ClassNotFoundException:
            case $e instanceof RouteNotFoundException:
            case $e instanceof TemplateNotFoundException:
                $statusCode = 404;
                $msg = '找不到内容';
                break;
            default:
        }
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $statusCode;
        $msg        = empty($msg) ? self::$statusTexts[$statusCode] : $msg;
//
        return json([
            'code'        => $code,
            'msg'         => $msg,
            'data'        => $data,
            'status_code' => $statusCode,
        ], $statusCode);

        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        // return parent::render($e);
    }

    /**
     * Status codes translation table.
     *
     * The list of codes is complete according to the
     * {@link http://www.iana.org/assignments/http-status-codes/ Hypertext Transfer Protocol (HTTP) Status Code Registry}
     * (last updated 2016-03-01).
     *
     * Unless otherwise noted, the status code is defined in RFC2616.
     *
     * @var array
     */
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];
}
