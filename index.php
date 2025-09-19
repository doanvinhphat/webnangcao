<?php
session_start();
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
// Nếu là admin thì luôn gọi layout
if ($module === 'admin') {
    $layout = 'pages/admin/admin_layout.php';
    if (file_exists($layout)) {
        require_once $layout;
    } else {
        require_once 'pages/errors/404.php';
    }
} else {
    // load các module khác
    $path = 'pages/' . $module . '/' . $action . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        require_once 'pages/errors/404.php';
    }
}
