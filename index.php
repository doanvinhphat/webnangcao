<?php
session_start(); 
ob_start();
ini_set('display_errors', 0);
error_reporting(0);
require_once 'Config.php';

require_once 'includes/phpmailer/PHPMailer.php';
require_once 'includes/phpmailer/SMTP.php';
require_once 'includes/phpmailer/Exception.php';

require_once 'includes/Functions.php';
require_once 'includes/Connect.php';
require_once 'includes/Database.php';
require_once 'includes/Sessions.php';



//gán mặc định
$module = _MODULE_DEFAULT;
$action = _ACTION_DEFAULT;

// [module] => [] , [action] => []
//kiểm tra trên URL có nếu có module - action thì gán
if (!empty($_GET['module'])) {
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']); //xoa khoảng cách
    }
}

if (!empty($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}

// echo $module . '</br>';
// echo $action;

//kiểm tra tồn tại trong thư mục
$path = 'pages/' . $module . '/' . $action . '.php';
//echo $path;
if (file_exists($path)) {
    require_once $path;
} else {
    require_once 'pages/errors/404.php';
}