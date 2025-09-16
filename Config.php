<?php
//cấu hình
date_default_timezone_set('Asia/Ho_Chi_Minh'); // cài đặt múi giờ Việt Nam
const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'Lists';

//vào website phải chạy qua index
const _INCODE = true;

//cấu hình đường dẫn
define('BASE_PATH', __DIR__); // đường dẫn gốc: C:\laragon\www\webnangcao
define('INCLUDES_PATH', BASE_PATH.'/includes'); // đường dẫn gốc: C:\laragon\www\webnangcao\includes
define('PAGE_PATH', BASE_PATH.'/pages'); // đường dẫn gốc: C:\laragon\www\webnangcao\pages


// URL gốc (cho trình duyệt)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$projectName = basename(dirname(__FILE__)); // tên thư mục dự án (webnangcao)
define('BASE_URL', $protocol . $host . '/' . $projectName);


define('ASSETS_URL', BASE_URL.'/assets'); // => http://localhost/webnangcao/assets


//thông tin kết nối 
const _HOST = 'localhost';
const _USER = 'root';
const _PASS = '';
const _DB = 'ecommerce-phone';
const _DRIVER = 'mysql';