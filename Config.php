<?php
//cấu hình
const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'Lists';

//vào website phải chạy qua index
const _INCODE = true;

//cấu hình đường dẫn
define('BASE_PATH', __DIR__); // đường dẫn gốc: C:\laragon\www\webnangcao
define('PAGE_PATH', BASE_PATH.'/pages'); // đường dẫn gốc: C:\laragon\www\webnangcao\pages


// URL gốc (cho trình duyệt)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$projectName = basename(dirname(__FILE__)); // tên thư mục dự án (webnangcao)
define('BASE_URL', $protocol . $host . '/' . $projectName);


define('ASSETS_URL', BASE_URL.'/assets'); // => http://localhost/webnangcao/assets