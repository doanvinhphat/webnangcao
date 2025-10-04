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

$currentUser = $_SESSION['currentUser'];
if ($currentUser && $currentUser['role'] != 'admin') {
    setFlashData('msg', 'Bạn không có quyền vào trang này');
    setFlashData('msg_type', 'warning');
    redirect('?module=home&action=lists');
}

// ❌ Không include trực tiếp nữa
// ✅ Trả về đường dẫn để layout include
return $file;
