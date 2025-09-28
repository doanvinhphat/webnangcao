<?php
$perPage = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// --- FILTER ---
$status = $_GET['status'] ?? ''; // all | active | expired
$params = [];
$where  = [];

$today = date('Y-m-d');

if ($status === 'active') {
    $where[] = "v.isActive = 1 AND v.start_date <= :today AND v.end_date >= :today";
    $params['today'] = $today;
} elseif ($status === 'expired') {
    $where[] = "(v.isActive = 0 OR v.end_date < :today)";
    $params['today'] = $today;
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";
$order    = "v.id DESC";

// --- COUNT ---
$countSql = "SELECT COUNT(*) as total FROM vouchers v $whereSql";
$row = first($countSql, $params);
$totalItems = $row ? $row['total'] : 0;
$totalPages = ceil($totalItems / $perPage);

// --- GET DATA ---
$sql = "SELECT v.*, u.fullname as created_by_name
        FROM vouchers v
        LEFT JOIN users u ON v.created_by = u.id
        $whereSql
        ORDER BY $order
        LIMIT $perPage OFFSET $offset";
$vouchers = getRows($sql, $params);

// Flash message
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<section class="px-2 mt-2">
    <?php getMsg($msg, $msgType); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh sách voucher</h1>
        <a href="<?= buildUrl('vouchers', 'Add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm voucher
        </a>
    </div>

    <hr class="border border-3 border-dark">

    <!-- Bộ lọc -->
    <form method="get" class="row my-4">
        <input type="hidden" name="module" value="admin">
        <input type="hidden" name="controller" value="vouchers">
        <input type="hidden" name="action" value="List">

        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tất cả --</option>
                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Còn hạn</option>
                <option value="expired" <?= $status === 'expired' ? 'selected' : '' ?>>Hết hạn</option>
            </select>
        </div>
    </form>

    <div class="my-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Mã</th>
                    <th>Giá trị (%)</th>
                    <th>Số lượng</th>
                    <th>Bắt đầu</th>
                    <th>Kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Người tạo</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($vouchers)) : ?>
                    <?php foreach ($vouchers as $v) :
                        $isExpired = ($v['isActive'] == 0 || $v['end_date'] < $today);
                    ?>
                        <tr class="<?= $isExpired ? 'table-danger' : '' ?>">
                            <td><?= $v['id'] ?></td>
                            <td><strong><?= htmlspecialchars($v['code']) ?></strong></td>
                            <td><?= $v['discount_value'] ?>%</td>
                            <td><?= $v['quantity'] ?></td>
                            <td><?= $v['start_date'] ?></td>
                            <td><?= $v['end_date'] ?></td>
                            <td>
                                <?php if ($isExpired): ?>
                                    <span class="badge bg-secondary">Hết hạn</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Còn hạn</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($v['created_by_name'] ?? '---') ?></td>
                            <td><?= $v['created_at'] ?></td>
                            <td><?= $v['updated_at'] ?></td>
                            <td>
                                <a href="<?= buildUrl('vouchers', 'Edit', ['id' => $v['id']]) ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="<?= buildUrl('vouchers', 'Delete', ['id' => $v['id']]) ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa voucher này?');">
                                    <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="text-center">Không tìm thấy voucher nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <hr class="border border-3 border-dark">

    <?= renderPagination($page, $totalPages, $perPage); ?>
</section>