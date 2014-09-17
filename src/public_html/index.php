<?php
define('ROOT_DIR', dirname(__FILE__).'/..');
defined('ROOT_PATH')
        || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
defined('APPLICATION_SERVER')
        || define('APPLICATION_SERVER', (getenv('APPLICATION_SERVER') ? getenv('APPLICATION_SERVER') : 's1'));


set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

define('MODULE','default');
require_once 'functions.php';
require_once APPLICATION_PATH . '/configs/'.MODULE.'/defined.php';
try {
    error_reporting(E_ALL);
    $config = APPLICATION_PATH . '/configs/'.MODULE.'/application-' . APPLICATION_ENV . '.ini';
    require_once 'Zend/Application.php';
    $application = new Zend_Application(
            APPLICATION_ENV, $config
    );
    $application->bootstrap()->run();
} catch (Exception $exception) {
    echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="refresh" content="4" /><title>123.vn</title></head><body>'
    . '<div style="padding:10px;text-align:center;color:#666666;font-size:16px;line-height:30px;text-transform:uppercase">'
    . 'Nội dung đang được cập nhật... vui lòng đợi trong giây lát!</div>';
    if (APPLICATION_ENV != 'production') {
        echo '<pre>';
        //print_r($exception);
        echo '<pre><br /><br />' . $exception->getMessage() . '<br />'
        . '<div align="left">Stack Trace:'
        . '<pre>' . $exception->getTraceAsString() . '</pre></div>';
    }
    echo '</body></html>';
    exit(1);
}