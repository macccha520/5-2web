<?php

if (extension_loaded('zlib')){
    ob_end_clean();
    ob_start('ob_gzhandler');
}

if(version_compare(PHP_VERSION,'5.4.0','<'))
    die('require PHP > 5.4.0 !');

error_reporting(E_ERROR | E_WARNING | E_PARSE);//报告运行时错误


define('PLUGIN_PATH', __DIR__ . '/plugins/');
define('UPLOAD_PATH','public/upload/');
define('TPSHOP_CACHE_TIME',86400);
define('SITE_URL','http://'.$_SERVER['HTTP_HOST']);
define('INSTALL_DATE',1463741583);
define('SERIALNUMBER','20160520065303oCWIoa');

define('APP_PATH', __DIR__ . '/application/');
define('NOW_TIME',$_SERVER['REQUEST_TIME']);
define('FUNC_PATH', __DIR__ . '/functions/');



require __DIR__ . '/thinkphp/start.php';
