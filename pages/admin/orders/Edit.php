<?php
// Lấy id đơn hàng
$body = getBody('get');
$orderId = !empty($body['id']) ? (int)$body['id'] : 0;

if ($orderId <= 0) {
    getMsg('Đơn hàng không tồn tại', 'danger');
    exit;
}

// Lấy chi tiết đơn hàng + user
$order = first("
    SELECT o.*, u.fullname, u.email, u.phone as user_phone 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = :id
", ['id' => $orderId]);

if (empty($order)) {
    getMsg('Không tìm thấy đơn hàng', 'danger');
    exit;
}

// Lấy danh sách sản phẩm trong đơn hàng
$orderItems = getRows("
    SELECT oi.*, p.name, p.image1 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = :order_id
", ['order_id' => $orderId]);

// Nếu submit form (POST) → update trạng thái
if (isPost()) {
    $postData = getBody('post');
    $newStatus = $postData['status'] ?? $order['status'];
    $oldStatus = $order['status'];

    if ($newStatus !== $oldStatus) {

        // Nếu chuyển sang cancelled thì hoàn stock
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $items = getRows("SELECT product_id, quantity FROM order_items WHERE order_id = :id", [
                'id' => $orderId
            ]);

            foreach ($items as $item) {
                query(
                    "UPDATE products SET stock = stock + :qty WHERE id = :pid",
                    [
                        'qty' => $item['quantity'],
                        'pid' => $item['product_id']
                    ]
                );
            }
        }

        // Cập nhật trạng thái đơn hàng
        $updated = update('orders', ['status' => $newStatus], "id = $orderId");

        if ($updated) {
            setFlashData('msg', 'Cập nhật trạng thái đơn hàng thành công');
            setFlashData('msg_type', 'success');
            $order['status'] = $newStatus;
            redirect('?module=admin&controller=orders&action=List');
        } else {
            getMsg("Có lỗi khi cập nhật trạng thái", 'danger');
        }
    } else {
        // Không thay đổi gì
        setFlashData('msg', 'Trạng thái không thay đổi');
        setFlashData('msg_type', 'info');
        redirect('?module=admin&controller=orders&action=Edit&id=' . $orderId);
    }
}

?>

<div class="px-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Cập nhật đơn hàng</h1>
        <a href="?module=admin&controller=orders&action=List" class="btn btn-secondary">Quay lại</a>
    </div>
    <hr class="border border-3 border-dark">

    <h3 class="mb-3">Chi tiết đơn hàng của khách: <?= htmlspecialchars($order['user_phone']) ?></h3>

    <!-- Thông tin đơn hàng -->
    <div class="card mb-4">
        <div class="card-header">Thông tin đơn hàng</div>
        <div class="card-body">
            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
            <p><strong>SĐT:</strong> <?= htmlspecialchars($order['user_phone']) ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
            <p><strong>Ngày tạo:</strong> <?= $order['created_at'] ?></p>
            <p><strong>Cập nhật gần nhất:</strong> <?= $order['updated_at'] ?></p>
        </div>
    </div>

    <!-- Sản phẩm -->
    <div class="card mb-4">
        <div class="card-header">Danh sách sản phẩm</div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th width="100">Số lượng</th>
                        <th width="120">Giá</th>
                        <th width="120">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orderItems)): ?>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item['image1'])): ?>
                                        <img src="<?= htmlspecialchars($item['image1']) ?>" alt="" width="70">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Không có sản phẩm</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Tổng cộng:</th>
                        <th><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Form cập nhật trạng thái -->
    <div class="card">
        <div class="card-header">Cập nhật trạng thái đơn hàng</div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select" required>
                        <?php
                        $statusList = [
                            'pending' => 'Chờ xử lý',
                            'processing' => 'Đang xử lý',
                            'shipped' => 'Đã giao',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã hủy'
                        ];
                        foreach ($statusList as $key => $label):
                        ?>
                            <option value="<?= $key ?>" <?= ($order['status'] == $key) ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>