<?php
if (!isset($_SESSION['currentUser'])) {
    setFlashData('msg', 'Vui lòng đăng nhập');
    setFlashData('msg_type', 'warning');
    redirect('?module=auth&action=login');
}

$userId = $_SESSION['currentUser']['id'];

// Lấy danh sách đơn hàng của user
$sql = "SELECT o.*
        FROM orders o
        WHERE o.user_id = :uid
        ORDER BY o.id DESC";
$orders = getRows($sql, ['uid' => $userId]);

$statusLabel = [
    'pending'    => 'Chờ xử lý',
    'processing' => 'Đang xử lý',
    'shipped'    => 'Đã gửi hàng',
    'completed'  => 'Hoàn thành',
    'cancelled'  => 'Đã bị admin hủy'
];
$statusClass = [
    'pending'    => 'secondary',
    'processing' => 'info',
    'shipped'    => 'primary',
    'completed'  => 'success',
    'cancelled'  => 'danger'
];
?>
<?php require_once 'templates/user/layouts/Header.php' ?>

<section class="container py-4">
    <h1 class="mb-4">Đơn hàng của tôi</h1>

    <?php if (!empty($orders)): ?>
        <div class="row g-4">
            <?php foreach ($orders as $order): ?>
                <?php
                // Lấy sản phẩm trong đơn
                $items = getRows(
                    "SELECT oi.*, p.name, p.image1
                     FROM order_items oi
                     JOIN products p ON oi.product_id = p.id
                     WHERE oi.order_id = :oid",
                    ['oid' => $order['id']]
                );
                ?>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><strong>Đơn #<?= $order['id'] ?></strong></span>
                            <span class="badge bg-<?= $statusClass[$order['status']] ?? 'secondary' ?>">
                                <?= $statusLabel[$order['status']] ?? $order['status'] ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <?php foreach ($items as $it): ?>
                                <div class="d-flex mb-3">
                                    <img src="<?= htmlspecialchars($it['image1'] ?: 'no-image.jpg') ?>"
                                        alt="<?= htmlspecialchars($it['name']) ?>"
                                        class="rounded me-3"
                                        style="width:80px; height:80px; object-fit:cover;">
                                    <div>
                                        <h6 class="mb-1"><?= htmlspecialchars($it['name']) ?></h6>
                                        <small>Số lượng: <?= $it['quantity'] ?></small><br>
                                        <small>Giá: <?= number_format($it['price'], 0, ',', '.') ?>₫</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <hr>
                            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
                            <p><strong>Tổng tiền:</strong>
                                <span class="text-danger fs-5">
                                    <?= number_format($order['total_amount'], 0, ',', '.') ?>₫
                                </span>
                            </p>
                            <p class="text-muted"><small>Ngày đặt: <?= $order['created_at'] ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <?php endif; ?>
</section>

<?php require_once 'templates/user/layouts/Footer.php' ?>