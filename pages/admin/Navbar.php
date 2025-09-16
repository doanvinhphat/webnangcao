<?php
// Lấy tên admin từ session
$adminName = $_SESSION['currentUser']['fullname'] ?? 'Admin';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="<?= BASE_URL ?>?module=admin">
        <i class="fa-solid fa-gauge"></i> Trang Quản Trị
    </a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <span class="nav-link text-white">
                    Xin chào, <strong><?= htmlspecialchars($adminName) ?></strong>
                </span>
            </li>
            <li class="nav-item">
                <a href="?module=auth&action=logout" class="nav-link text-white">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </a>
            </li>
        </ul>
    </div>
</nav>