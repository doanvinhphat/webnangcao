<?php

$perPage = 10;

// --- TRANG HIỆN TẠI ---
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Lấy dữ liệu từ filter
$status = $_GET['status'] ?? '';
$phone  = trim($_GET['phone'] ?? '');

// WHERE
$where = [];
$params = [];

if (!empty($status)) {
    $where[] = "o.status = :status";
    $params['status'] = $status;
}

if (!empty($phone)) {
    $where[] = "o.phone LIKE :phone";
    $params['phone'] = '%' . $phone . '%';
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

// ORDER (mới nhất trước)
$order = "o.id DESC";

// Đếm tổng số đơn
$countSql = "SELECT COUNT(*) as total 
             FROM orders o 
             LEFT JOIN users u ON o.user_id = u.id
             $whereSql";
$row = first($countSql, $params);
$totalItems = $row ? $row['total'] : 0;
$totalPages = ceil($totalItems / $perPage);

// Lấy danh sách đơn
$sql = "SELECT o.*, u.fullname 
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        $whereSql
        ORDER BY $order
        LIMIT $perPage OFFSET $offset";

$orders = getRows($sql, $params);

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<section class="px-2 mt-2">
    <?php getMsg($msg, $msgType); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh sách đơn hàng</h1>
    </div>

    <hr class="border border-3 border-dark">

    <!-- Bộ lọc -->
    <form method="get" class="row my-4">
        <input type="hidden" name="module" value="admin">
        <input type="hidden" name="controller" value="orders">
        <input type="hidden" name="action" value="List">

        <!-- Tìm theo số điện thoại -->
        <div class="col-md-3">
            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại..."
                value="<?= htmlspecialchars($phone) ?>">
        </div>

        <!-- Lọc theo trạng thái -->
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                <option value="processing" <?= $status === 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                <option value="shipped" <?= $status === 'shipped' ? 'selected' : '' ?>>Đã gửi hàng</option>
                <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="<?= buildUrl('orders', 'List') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="my-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)) : ?>
                    <?php foreach ($orders as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['id']) ?></td>
                            <td><?= htmlspecialchars($item['fullname'] ?? '---') ?></td>
                            <td class="text-ellipsis" title="<?= htmlspecialchars($item['shipping_address']) ?>">
                                <?= htmlspecialchars($item['shipping_address']) ?>
                            </td>
                            <td><?= htmlspecialchars($item['phone']) ?></td>
                            <td><strong class="text-danger"><?= number_format($item['total_amount'], 0, ',', '.') ?>₫</strong></td>
                            <td>
                                <?php
                                $statusLabel = [
                                    'pending'    => 'Chờ xử lý',
                                    'processing' => 'Đang xử lý',
                                    'shipped'    => 'Đã gửi hàng',
                                    'completed'  => 'Hoàn thành',
                                    'cancelled'  => 'Đã hủy'
                                ];
                                $statusClass = [
                                    'pending'    => 'secondary',
                                    'processing' => 'info',
                                    'shipped'    => 'primary',
                                    'completed'  => 'success',
                                    'cancelled'  => 'danger'
                                ];
                                ?>
                                <span class="badge bg-<?= $statusClass[$item['status']] ?? 'secondary' ?>">
                                    <?= $statusLabel[$item['status']] ?? $item['status'] ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($item['created_at']) ?></td>
                            <td><?= htmlspecialchars($item['updated_at']) ?></td>
                            <td>
                                <a href="<?= buildUrl('orders', 'Edit', ['id' => $item['id']]) ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Cập nhật
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">Không tìm thấy đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <hr class="border border-3 border-dark">

    <?= renderPagination($page, $totalPages, $perPage); ?>
</section>