<?php
$totalUsers = first("SELECT COUNT(*) as total FROM users");

// Lấy số lượng products
$totalProducts = first("SELECT COUNT(*) as total FROM products");

// Lấy số lượng categories
$totalCategories = first("SELECT COUNT(*) as total FROM categories");

// Lấy số lượng vouchers
$totalVouchers = first("SELECT COUNT(*) as total FROM vouchers");

// Lấy số lượng orders
$totalOrders = first("SELECT COUNT(*) as total FROM orders");

// Doanh thu thực tế (completed orders)
$totalRevenueCompleted = first("SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'");

// Doanh thu dự kiến (pending, processing, shipping...)
$totalRevenuePending = first("SELECT SUM(total_amount) as total FROM orders WHERE status != 'completed'");

?>

<div class="container mt-3">
    <div class="row g-3">

        <!-- Users -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="text-primary fs-1 mb-2">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h6 class="text-muted">Người dùng</h6>
                    <h4 class="fw-bold text-primary"><?= $totalUsers['total'] ?? 0; ?></h4>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="fs-1 mb-2" style="color:#6f42c1">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <h6 class="text-muted">Sản phẩm</h6>
                    <h4 class="fw-bold" style="color:#6f42c1"><?= $totalProducts['total'] ?? 0; ?></h4>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="text-warning fs-1 mb-2">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <h6 class="text-muted">Danh mục</h6>
                    <h4 class="fw-bold text-warning"><?= $totalCategories['total'] ?? 0; ?></h4>
                </div>
            </div>
        </div>

        <!-- Vouchers -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="text-danger fs-1 mb-2">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <h6 class="text-muted">Vouchers</h6>
                    <h4 class="fw-bold text-danger"><?= $totalVouchers['total'] ?? 0; ?></h4>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="text-info fs-1 mb-2">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <h6 class="text-muted">Đơn hàng</h6>
                    <h4 class="fw-bold text-info"><?= $totalOrders['total'] ?? 0; ?></h4>
                </div>
            </div>
        </div>

        <!-- Revenue Completed -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="text-success fs-1 mb-2">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <h6 class="text-muted">Doanh thu (Thực tế)</h6>
                    <h4 class="fw-bold text-success">
                        <?= number_format($totalRevenueCompleted['total'] ?? 0, 0, ',', '.'); ?> đ
                    </h4>
                </div>
            </div>
        </div>

        <!-- Revenue Pending -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow h-100 text-center border-0">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="text-secondary  fs-1 mb-2">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <h6 class="text-muted">Doanh thu (Dự kiến)</h6>
                    <h4 class="fw-bold text-secondary ">
                        <?= number_format($totalRevenuePending['total'] ?? 0, 0, ',', '.'); ?> đ
                    </h4>
                </div>
            </div>
        </div>

    </div>
</div>