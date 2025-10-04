<?php
$perPage = 6;

// --- TRANG HIỆN TẠI ---
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Lấy dữ liệu từ filter
$keyword    = $_GET['keyword'] ?? '';
$sort       = $_GET['sort'] ?? 'desc';
$isActive   = $_GET['isActive'] ?? '';

// WHERE
$where = [];
$params = [];

if (!empty($keyword)) {
    $where[] = "(u.fullname LIKE :kw OR u.email LIKE :kw)";
    $params['kw'] = '%' . $keyword . '%';
}

if ($isActive !== '') { // 0 hoặc 1 đều hợp lệ
    $where[] = "u.isActive = :isActive";
    $params['isActive'] = $isActive;
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

// ORDER
$order = $sort === 'asc' ? "u.id ASC" : "u.id DESC";

$countSql = "SELECT COUNT(*) as total FROM users u $whereSql";
$row = first($countSql, $params);
$totalItems = $row ? $row['total'] : 0;
$totalPages = ceil($totalItems / $perPage);

$sql = "SELECT *
        FROM users u
        $whereSql
        ORDER BY $order
        LIMIT $perPage OFFSET $offset";

$users = getRows($sql, $params);

// Flash message
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<section class="px-2 mt-2">
    <?php getMsg($msg, $msgType); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quản lý người dùng</h1>
    </div>

    <hr class="border border-3 border-dark">

    <!-- Bộ lọc -->
    <form method="get" class="row my-4">
        <input type="hidden" name="module" value="admin">
        <input type="hidden" name="controller" value="users">
        <input type="hidden" name="action" value="List">

        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm tên hoặc email..."
                value="<?= htmlspecialchars($keyword) ?>">
        </div>

        <div class="col-md-3">
            <select name="isActive" class="form-select" onchange="this.form.submit()">
                <option value="">-- Trạng thái --</option>
                <option value="1" <?= $isActive === '1' ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $isActive === '0' ? 'selected' : '' ?>>Khóa</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Cũ nhất</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="<?= buildUrl('users', 'List') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="my-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo tài khoản</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['fullname']) ?></td>
                            <td><?= htmlspecialchars($item['email']) ?></td>
                            <td><?= htmlspecialchars($item['phone']) ?></td>
                            <td>
                                <?php if ($item['role'] === 'admin') : ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php elseif ($item['role'] === 'user') : ?>
                                    <span class="badge bg-primary">User</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($item['role']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($item['isActive']) : ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Khóa</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['created_at']) ?></td>
                            <td>
                                <?php if ($item['role'] != 'admin'): ?>
                                    <a href="<?= buildUrl('users', 'Edit', ['id' => $item['id']]) ?>" class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Không tìm người dùng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <hr class="border border-3 border-dark">

    <?= renderPagination($page, $totalPages, $perPage); ?>
</section>