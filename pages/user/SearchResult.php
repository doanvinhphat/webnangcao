<?php require_once 'templates/user/layouts/Header.php' ?>

<div class="container my-4">
    <h4>Kết quả tìm kiếm cho: <b><?= htmlspecialchars($body['keyword']) ?></b></h4>
    <div class="row">
        <?php foreach ($products as $item): ?>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <img src="<?= $item['image1'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="card-body">
                        <h6 class="card-title"><?= htmlspecialchars($item['name']) ?></h6>
                        <p class="card-text text-danger fw-bold">
                            <?= number_format($item['price']) ?> đ
                        </p>
                        <a href="?module=user&action=detail&slug=<?= $item['slug'] ?>" class="btn btn-sm btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'templates/user/layouts/Footer.php' ?>