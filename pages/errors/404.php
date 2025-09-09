<?php 
$pageTitle = "404 - Không tìm thấy trang";
require_once 'templates/user/layouts/Header.php'; 
?>

<div class="container text-center py-5">
    <h1 class="display-4 text-danger">404</h1>
    <p class="lead">Xin lỗi, trang bạn tìm không tồn tại hoặc đã bị xóa.</p>
    <a href="index.php" class="btn btn-primary">Về trang chủ</a>
</div>

<?php require_once 'templates/user/layouts/Footer.php'; ?>
