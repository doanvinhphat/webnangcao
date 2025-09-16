<?php
// pages/admin/index.php

$controller = !empty($_GET['controller']) ? trim($_GET['controller']) : null;
$action = !empty($_GET['action']) ? trim($_GET['action']) : 'dashboard';

$baseDir = __DIR__; // pages/admin

if ($controller) {
    // vd: pages/admin/users/Add.php
    $file = $baseDir . '/' . $controller . '/' . ucfirst($action) . '.php';
} else {
    // vd: pages/admin/Dashboard.php
    $file = $baseDir . '/' . ucfirst($action) . '.php';
}

if (!file_exists($file)) {
    $file = PAGE_PATH . '/errors/404.php';
}

// ❌ Không include trực tiếp nữa
// ✅ Trả về đường dẫn để layout include
return $file;
