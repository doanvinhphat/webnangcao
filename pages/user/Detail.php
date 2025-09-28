<?php
// Lấy slug từ URL
$slug = $_GET['slug'] ?? null;

// echo 'Đã lấy được slug: ' . $slug;

if ($slug) {
    //lấy thông tin
    $productDetail = first("SELECT * FROM products WHERE slug = ?", [$slug]);

    if (!empty($productDetail)) {
        // Lấy các sản phẩm liên quan cùng category (trừ sản phẩm hiện tại)
        $relatedProducts = getRows(
            "SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4",
            [$productDetail['category_id'], $productDetail['id']]
        );
    } else {
        require_once PAGE_PATH . '/errors/404.php';
    }
}

// Nếu có tham số add_to_cart
if (!empty($_GET['add_to_cart'])) {
    // check login
    if (empty($_SESSION['currentUser'])) {
        setFlashData('msg', 'Vui lòng đăng nhập!');
        setFlashData('msg_type', 'warning');
        redirect('?module=auth&action=login');
        exit;
    }

    $productId = (int) $_GET['add_to_cart'];
    $product   = first("SELECT * FROM products WHERE id = ?", [$productId]);

    if (!empty($product)) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['qty'] += 1;
        } else {
            $_SESSION['cart'][$productId] = [
                'id'    => $product['id'],
                'name'  => $product['name'],
                'price' => $product['discount_price'] ?? $product['price'],
                'image' => $product['image1'],
                'qty'   => 1
            ];
        }

        setFlashData('msg', 'Đã thêm sản phẩm vào giỏ hàng!');
        setFlashData('msg_type', 'success');
    } else {
        setFlashData('msg', 'Sản phẩm không tồn tại!');
        setFlashData('msg_type', 'danger');
    }

    // Redirect để tránh việc bấm F5 bị cộng thêm lần nữa
    redirect("?module=user&action=detail&slug=" . $productDetail['slug']);
    exit;
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
<?php require_once 'templates/user/layouts/Header.php' ?>

<div class="container my-5">
    <?php getMsg($msg, $msgType); ?>
    <div class="row g-4">
        <!-- Cột trái: Hình ảnh -->
        <div class="col-md-4">
            <!-- Ảnh chính -->
            <div class="ratio ratio-1x1 border rounded mb-3">
                <img id="mainImage"
                    src="<?= htmlspecialchars($productDetail['image1']) ?>"
                    alt="<?= htmlspecialchars($productDetail['name']) ?>"
                    class="img-fluid object-fit-contain p-2">
            </div>

            <!-- Thumbnail -->
            <div class="d-flex gap-2">
                <?php
                $images = [$productDetail['image1'], $productDetail['image2'], $productDetail['image3']];
                foreach ($images as $img):
                    if (!empty($img)): ?>
                        <div class="ratio ratio-1x1 border rounded thumb" style="width: 80px; cursor:pointer;">
                            <img src="<?= htmlspecialchars($img) ?>"
                                class="img-fluid object-fit-contain p-1 thumbnail-img"
                                alt="Thumbnail">
                        </div>
                <?php endif;
                endforeach; ?>
            </div>
        </div>

        <!-- Cột phải: Thông tin -->
        <div class="col-md-8">
            <h3 class="mb-3"><?= htmlspecialchars($productDetail['name']) ?></h3>

            <!-- Giá -->
            <div class="d-flex align-items-baseline gap-3 mb-3">
                <strong class="text-danger fs-4">
                    <?= number_format($productDetail['discount_price'] ?? $productDetail['price'], 0, ',', '.') ?>₫
                </strong>

                <?php if ($productDetail['discount_percent'] > 0): ?>
                    <span class="text-muted text-decoration-line-through">
                        <?= number_format($productDetail['price'], 0, ',', '.') ?>₫
                    </span>
                    <span class="badge bg-light text-muted border">
                        -<?= $productDetail['discount_percent'] ?>%
                    </span>
                <?php endif; ?>
            </div>

            <!-- Mô tả -->
            <p class="text-muted mb-3">
                <?= nl2br(htmlspecialchars($productDetail['description'])) ?>
            </p>

            <!-- Số lượng tồn -->
            <?php if ($productDetail['stock'] > 0): ?>
                <p><strong>Còn hàng:</strong> <?= (int)$productDetail['stock'] ?> sản phẩm</p>
                <!-- Nút thêm vào giỏ -->
                <a href="?module=user&action=detail&slug=<?= $productDetail['slug'] ?>&add_to_cart=<?= $productDetail['id'] ?>"
                    class="btn btn-success px-4">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                </a>
            <?php else: ?>
                <p><strong>Hết hàng</strong></p>
                <button class="btn btn-secondary px-4" disabled>
                    <i class="bi bi-x-circle"></i> Hết hàng
                </button>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php if (!empty($relatedProducts)): ?>
    <div class="container my-5">
        <h4 class="mb-4">Sản phẩm tương tự</h4>
        <div class="row g-4">
            <?php foreach ($relatedProducts as $item): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <a href="?module=user&action=detail&slug=<?= htmlspecialchars($item['slug']); ?>"
                            class="text-decoration-none text-dark">
                            <div class="ratio ratio-4x3">
                                <img src="<?= htmlspecialchars($item['image1']); ?>"
                                    class="card-img-top object-fit-contain p-2"
                                    alt="<?= htmlspecialchars($item['name']); ?>">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title text-truncate"><?= htmlspecialchars($item['name']); ?></h6>
                                <div class="d-flex align-items-baseline justify-content-between mb-2">
                                    <strong class="text-danger fs-6">
                                        <?= number_format($item['discount_price'] ?? $item['price'], 0, ',', '.') ?>₫
                                    </strong>
                                    <?php if ($item['discount_percent'] > 0): ?>
                                        <div class="position-relative">
                                            <span class="text-muted text-decoration-line-through small">
                                                <?= number_format($item['price'], 0, ',', '.') ?>₫
                                            </span>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-muted border">
                                                -<?= $item['discount_percent'] ?>%
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'templates/user/layouts/Footer.php' ?>