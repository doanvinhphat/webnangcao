<?php

$perPage = 6;

// --- TRANG HIỆN TẠI ---
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Lấy dữ liệu từ filter
$keyword    = $_GET['keyword'] ?? '';
$sort       = $_GET['sort'] ?? 'desc';
$isActive   = $_GET['isActive'] ?? '';
$categoryId = $_GET['category_id'] ?? '';

// WHERE
$where = [];
$params = [];

if (!empty($keyword)) {
    $where[] = "(p.name LIKE :kw OR p.slug LIKE :kw)";
    $params['kw'] = '%' . $keyword . '%';
}

if ($isActive !== '') { // 0 hoặc 1 đều hợp lệ
    $where[] = "p.isActive = :isActive";
    $params['isActive'] = $isActive;
}

if (!empty($categoryId)) {
    $where[] = "p.category_id = :category_id";
    $params['category_id'] = $categoryId;
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

// ORDER
$order = $sort === 'asc' ? "p.id ASC" : "p.id DESC";

$countSql = "SELECT COUNT(*) as total FROM products p $whereSql";
$row = first($countSql, $params);
$totalItems = $row ? $row['total'] : 0;
$totalPages = ceil($totalItems / $perPage);

$sql = "SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        $whereSql
        ORDER BY $order
        LIMIT $perPage OFFSET $offset";

$products = getRows($sql, $params);

// Flash message
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<section class="px-2 mt-2">
    <?php getMsg($msg, $msgType); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh sách sản phẩm</h1>
        <a href="<?= buildUrl('products', 'Add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
        </a>
    </div>

    <hr class="border border-3 border-dark">

    <!-- Bộ lọc -->
    <form method="get" class="row my-4">
        <input type="hidden" name="module" value="admin">
        <input type="hidden" name="controller" value="products">
        <input type="hidden" name="action" value="List">

        <div class="col-md-3">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..."
                value="<?= htmlspecialchars($keyword) ?>">
        </div>

        <div class="col-md-2">
            <select name="isActive" class="form-select" onchange="this.form.submit()">
                <option value="">-- Trạng thái --</option>
                <option value="1" <?= $isActive === '1' ? 'selected' : '' ?>>Hiển thị</option>
                <option value="0" <?= $isActive === '0' ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="category_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Chọn danh mục --</option>
                <?php
                $categories = getRows("SELECT * FROM categories ORDER BY name ASC");
                foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $categoryId == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Cũ nhất</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="<?= buildUrl('products', 'List') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="my-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Giảm giá</th>
                    <th>Kho</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['id']) ?></td>
                            <td>
                                <?php if (!empty($item['image1'])) : ?>
                                    <img src="<?= BASE_URL . '/' . $item['image1'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="60" class="rounded">
                                <?php else : ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['category_name'] ?? 'Chưa có') ?></td>
                            <td>
                                <span class="text-decoration-line-through text-muted">
                                    <?= number_format($item['price'], 0, ',', '.') ?>₫
                                </span><br>
                                <strong class="text-danger">
                                    <?= number_format($item['discount_price'] ?? $item['price'], 0, ',', '.') ?>₫
                                </strong>
                            </td>
                            <td><?= htmlspecialchars($item['discount_percent']) ?>%</td>
                            <td><?= htmlspecialchars($item['stock']) ?></td>
                            <td>
                                <?php if ($item['isActive']) : ?>
                                    <span class="badge bg-success">Hiển thị</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['created_at']) ?></td>
                            <td><?= htmlspecialchars($item['updated_at']) ?></td>
                            <td>
                                <a href="<?= buildUrl('products', 'Edit', ['id' => $item['id']]) ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="<?= buildUrl('products', 'Delete', ['id' => $item['id']]) ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="text-center">Không tìm thấy sản phẩm nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <hr class="border border-3 border-dark">

    <?= renderPagination($page, $totalPages, $perPage); ?>
</section>