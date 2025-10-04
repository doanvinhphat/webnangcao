<?php require_once 'templates/user/layouts/Header.php'; ?>

<div class="container my-5 text-center">
    <h4>Kết quả tìm kiếm cho: <b><?= htmlspecialchars($body['keyword']) ?></b></h4>
    <p class="text-muted">Rất tiếc, không tìm thấy sản phẩm nào phù hợp với từ khóa này.</p>
    <a href="?module=home&action=lists" class="btn btn-primary">Quay về trang chủ</a>
</div>

<?php require_once 'templates/user/layouts/Footer.php'; ?>