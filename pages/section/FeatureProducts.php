<?php

// Lấy 8 sản phẩm mới nhất còn hàng
$sql = "SELECT p.*
        FROM products p
        WHERE p.stock > 0
        ORDER BY p.created_at DESC
        LIMIT 8";

$products = getRows($sql);
?>

<section class="container my-5">
    <div class="d-flex justify-content-center align-items-center mb-4">
        <h2 class="fw-bold">Sản phẩm nổi bật</h2>
    </div>

    <div class="row g-4">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm border-0 card-hover">
                        <a href="?module=user&action=detail&slug=<?= htmlspecialchars($product['slug']) ?>"
                            class="text-decoration-none text-dark">

                            <!-- Ảnh sản phẩm -->
                            <div class="ratio ratio-4x3">
                                <?php if (!empty($product['image1'])) : ?>
                                    <img src="<?= BASE_URL . '/' . $product['image1'] ?>"
                                        class="card-img-top object-fit-contain p-2"
                                        alt="<?= htmlspecialchars($product['name']) ?>">
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/300x200?text=No+Image"
                                        class="card-img-top p-2" alt="No image">
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <!-- Tên sản phẩm -->
                                <h6 class="card-title text-truncate mb-2">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h6>

                                <!-- Giá -->
                                <div class="d-flex align-items-baseline justify-content-between mb-2">
                                    <strong class="text-danger fs-6">
                                        <?= number_format($product['discount_price'] ?? $product['price'], 0, ',', '.') ?>₫
                                    </strong>

                                    <?php if (!empty($product['discount_percent']) && $product['discount_percent'] > 0): ?>
                                        <div class="position-relative">
                                            <span class="text-muted text-decoration-line-through small">
                                                <?= number_format($product['price'], 0, ',', '.') ?>₫
                                            </span>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-muted border">
                                                -<?= $product['discount_percent'] ?>%
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Mô tả ngắn -->
                                <p class="card-text small text-muted">
                                    <?php
                                    $desc = strip_tags($product['description']);
                                    echo mb_strlen($desc) > 60 ? mb_substr($desc, 0, 60) . '...' : $desc;
                                    ?>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center">
                <p class="text-muted">Chưa có sản phẩm nổi bật</p>
            </div>
        <?php endif; ?>
    </div>
</section>