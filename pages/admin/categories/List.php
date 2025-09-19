<?php
// --- CẤU HÌNH SỐ ITEM MỖI TRANG (tùy chỉnh) ---
$perPage = 6;

// --- LẤY TRANG HIỆN TẠI ---
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Lấy dữ liệu từ filter
$keyword = $_GET['keyword'] ?? '';
$sort    = $_GET['sort'] ?? 'desc';

// WHERE
$where = [];
$params = [];

if (!empty($keyword)) {
    $where[] = "(c.name LIKE :kw OR c.slug LIKE :kw)";
    $params['kw'] = '%' . $keyword . '%';
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

// ORDER
$order = $sort === 'desc' ? "c.id ASC" : "c.id DESC";

// --- ĐẾM TỔNG DÒNG ---
$countSql = "SELECT COUNT(*) FROM categories c $whereSql";
$row = first($countSql, $params); // trả về giá trị count
$totalItems = $row ? array_values($row)[0] : 0;
$totalPages = ceil($totalItems / $perPage);

// --- QUERY PHÂN TRANG ---
$sql = "SELECT c.*, u1.fullname AS created_by_name, u2.fullname AS updated_by_name
        FROM categories c
        LEFT JOIN users u1 ON c.created_by = u1.id
        LEFT JOIN users u2 ON c.updated_by = u2.id
        $whereSql
        ORDER BY $order
        LIMIT $perPage OFFSET $offset";

$categories = getRows($sql, $params);

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<section class="px-2 mt-2">
    <?php getMsg($msg, $msgType); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh sách danh mục</h1>
    </div>
    <?php require_once 'Add.php' ?>

    <hr class="border border-3 border-dark">

    <!-- Bộ lọc -->
    <form method="get" class="row my-4">
        <input type="hidden" name="module" value="admin">
        <input type="hidden" name="controller" value="categories">
        <input type="hidden" name="action" value="List">

        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm danh mục..."
                value="<?= htmlspecialchars($keyword) ?>">
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Cũ nhất</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="<?= buildUrl('categories', 'List') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="my-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Người tạo</th>
                    <th>Người cập nhật</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $cat) : ?>
                        <tr>
                            <td><?= htmlspecialchars($cat['id']) ?></td>
                            <td><?= htmlspecialchars($cat['name']) ?></td>
                            <td><?= htmlspecialchars($cat['slug']) ?></td>
                            <td><?= htmlspecialchars($cat['created_by_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($cat['updated_by_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($cat['created_at']) ?></td>
                            <td><?= htmlspecialchars($cat['updated_at']) ?></td>
                            <td>
                                <a href="<?= buildUrl('categories', 'Edit', ['id' => $cat['id']]) ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="<?= buildUrl('categories', 'Delete', ['id' => $cat['id']]) ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                    <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="text-center">Không tìm thấy danh mục nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <hr class="border border-3 border-dark">

    <?= renderPagination($page, $totalPages, $perPage); ?>
</section>