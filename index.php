<?php
ini_set('display_errors', 1);
session_start();
ob_implicit_flush(0);
    //header('Access-Control-Allow-Origin: http://caffe.ru');
    //header('Access-Control-Allow-Headers: Cookie, origin, x-requested-with, content-type');
    //header('Access-Control-Allow-Credentials: true');
    //header('Access-Control-Allow-Methods: GET,POST');
date_default_timezone_set("Europe/Moscow");
//error_reporting(E_ALL);
//$start = microtime(true);
//$
//defines pathmap
//$
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
define('VENDOR_PATH', ROOT . 'vendor' . DIRECTORY_SEPARATOR);
define('CLASS_PATH', VENDOR_PATH . 'class' . DIRECTORY_SEPARATOR);
define('LOG_PATH', VENDOR_PATH . 'log' . DIRECTORY_SEPARATOR);
define('INTERFACE_PATH', VENDOR_PATH . 'interface' . DIRECTORY_SEPARATOR);
define('MODEL_PATH', VENDOR_PATH . 'model' . DIRECTORY_SEPARATOR);
define('MODULE_PATH', VENDOR_PATH . 'module' . DIRECTORY_SEPARATOR);
define('EXTENTION_PATH', VENDOR_PATH .'class/ext' . DIRECTORY_SEPARATOR);
//echo ROOT . '<br>';
//echo VENDOR_PATH . '<br>';
//echo CLASS_PATH . '<br>';
//echo INTERFACE_PATH . '<br>';
//echo MODEL_PATH . '<br>';
//echo MODULE_PATH . '<br>';
//
//
//
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'api');
define('DB_TYPE', 'mysql');
//echo DB_USER . '<br>';
//echo DB_PASS . '<br>';
//echo DB_HOST . '<br>';
//echo DB_NAME . '<br>';
//echo DB_TYPE . '<br>';
//
//load autoloader
//
require_once VENDOR_PATH . 'autoloader.php';
//
//init data handler (recieve and send client data)
//
$dataHandler = new DataHandler();
//$end = microtime(true);
//echo ($end-$start) * 1000;
?>