<?php
if ($_SESSION['currentUser']) {
    $currentUser = $_SESSION['currentUser'];
} else {
    setFlashData('msg', 'Vui lòng đăng nhập!');
    setFlashData('msg_type', 'warning');
    redirect('?module=auth&action=login');
}

// Lấy danh sách vouchers còn hiệu lực
$vouchers = getRows("SELECT code, discount_value FROM vouchers WHERE isActive = 1 AND quantity > 0");

$body = getBody();

// --- FORM GIỎ HÀNG ---
if (isPost()) {

    // Cập nhật giỏ hàng
    if (!empty($body['update_cart']) && !empty($body['qty'])) {
        foreach ($body['qty'] as $productId => $newQty) {
            $newQty = max(1, (int)$newQty);

            // Lấy stock thực tế từ DB
            $product = first("SELECT stock FROM products WHERE id = " . (int)$productId);
            if ($product && $newQty > $product['stock']) {
                $newQty = $product['stock'];
                setFlashData('msg', 'Sản phẩm ID ' . $productId . ' chỉ còn ' . $product['stock'] . ' sản phẩm!');
                setFlashData('msg_type', 'warning');
            }

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['qty'] = $newQty;
            }
        }
        redirect('?module=user&action=checkout');
    }

    // Xóa 1 sản phẩm
    if (!empty($body['remove_item'])) {
        $productId = (int)$body['remove_item'];
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        redirect('?module=user&action=checkout');
    }

    // Xóa toàn bộ giỏ hàng
    if (!empty($body['clear_cart'])) {
        removeSession('cart');
        redirect('?module=user&action=checkout');
    }
}

// --- FORM ĐẶT HÀNG ---
if (isPost() && ($body['action'] ?? '') === 'place_order') {
    $errors = [];

    $cart = $body['cart'] ?? [];
    if (empty($cart)) {
        $errors['cart'] = 'Giỏ hàng trống!';
    }

    $shippingAddress = trim($body['shipping_address'] ?? '');
    if (!$shippingAddress) {
        $errors['shipping_address'] = 'Vui lòng nhập địa chỉ giao hàng';
    }

    if (empty($errors)) {
        $cartTotal = 0;
        foreach ($cart as $id => $item) {
            $cartTotal += $item['qty'] * $item['price'];
        }

        // Xử lý voucher
        $voucherCode = trim($body['voucher_code'] ?? '');
        if ($voucherCode) {
            $voucher = first("SELECT * FROM vouchers WHERE code=:code AND isActive=1 AND quantity>0", ['code' => $voucherCode]);
            if ($voucher) {
                $cartTotal = $cartTotal * (100 - $voucher['discount_value']) / 100;
                update('vouchers', ['quantity' => $voucher['quantity'] - 1], 'id=' . (int)$voucher['id']);
            } else {
                setFlashData('msg', 'Voucher không hợp lệ hoặc đã hết!');
                setFlashData('msg_type', 'warning');
                redirect('?module=user&action=checkout');
            }
        }

        // Lưu đơn hàng
        $orderData = [
            'user_id' => $currentUser['id'],
            'total_amount' => $cartTotal,
            'shipping_address' => $shippingAddress,
            'phone' => $currentUser['phone'],
            'status' => 'pending'
        ];
        insert('orders', $orderData);
        global $conn;
        $orderId = $conn->lastInsertId();

        // Lưu order_items & trừ stock
        foreach ($cart as $id => $item) {
            $product = first("SELECT stock FROM products WHERE id=" . (int)$id);
            if (!$product || $product['stock'] < $item['qty']) {
                setFlashData('msg', 'Sản phẩm "' . ($item['name'] ?? '') . '" không đủ số lượng!');
                setFlashData('msg_type', 'danger');
                redirect('?module=user&action=checkout');
            }
            insert('order_items', [
                'order_id' => $orderId,
                'product_id' => $id,
                'quantity' => $item['qty'],
                'price' => $item['price']
            ]);
            update('products', ['stock' => $product['stock'] - $item['qty']], 'id=' . (int)$id);
        }

        removeSession('cart');
        setFlashData('msg', 'Đặt hàng thành công! Mã đơn #' . $orderId);
        setFlashData('msg_type', 'success');
        redirect('?module=user&action=checkout');
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại thông tin');
        setFlashData('msg_type', 'danger');
        redirect('?module=user&action=checkout');
    }
}

// Tính tổng tiền giỏ hàng hiện tại (hiển thị)
$cartTotal = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartTotal += $item['qty'] * $item['price'];
    }
}
?>
<?php require_once 'templates/user/layouts/Header.php' ?>

<div class="container my-5">
    <div class="row">
        <!-- Cột trái: giỏ hàng -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-cart-check"></i> Thông tin đơn hàng
                </div>
                <div class="card-body">
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <form method="post">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Giá</th>
                                            <th class="text-end">Thành tiền</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($_SESSION['cart'] as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="rounded border me-2" style="width:50px;height:50px;object-fit:cover;">
                                                        <span><?= htmlspecialchars($item['name']) ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center" style="width:120px;">
                                                    <input type="number" name="qty[<?= $item['id'] ?>]" value="<?= $item['qty'] ?>" min="1" class="form-control text-center">
                                                </td>
                                                <td class="text-end"><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                                <td class="text-end"><?= number_format($item['qty'] * $item['price'], 0, ',', '.') ?>₫</td>
                                                <td class="text-center">
                                                    <button type="submit" name="remove_item" value="<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-start align-middle">
                                                <div class="d-flex align-items-center">
                                                    <label class="me-2 fw-normal">Mã giảm giá:</label>
                                                    <select class="form-select w-auto" id="voucher_select">
                                                        <option value="">-- Chọn voucher --</option>
                                                        <?php foreach ($vouchers as $v): ?>
                                                            <option value="<?= htmlspecialchars($v['code']) ?>"><?= htmlspecialchars($v['code']) ?> (Giảm <?= htmlspecialchars($v['discount_value']) ?>%)</option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </th>
                                            <th colspan="3" class="text-end align-middle">
                                                <span class="fw-bold">Tổng cộng:</span>
                                                <span class="text-danger ms-2"><?= number_format($cartTotal, 0, ',', '.') ?>₫</span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" name="update_cart" value="1" class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> Cập nhật giỏ hàng</button>
                                <button type="submit" name="clear_cart" value="1" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng không?')"><i class="bi bi-x-circle"></i> Xóa hết</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">Giỏ hàng trống.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Cột phải: form đặt hàng -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-person-lines-fill"></i> Thông tin giao hàng
                </div>
                <div class="card-body">
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <form method="post" id="place_order_form">
                            <input type="hidden" name="action" value="place_order">
                            <input type="hidden" name="voucher_code" id="voucher_code_hidden" value="">
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <input type="hidden" name="cart[<?= $item['id'] ?>][qty]" value="<?= $item['qty'] ?>">
                                <input type="hidden" name="cart[<?= $item['id'] ?>][price]" value="<?= $item['price'] ?>">
                                <input type="hidden" name="cart[<?= $item['id'] ?>][name]" value="<?= htmlspecialchars($item['name']) ?>">
                            <?php endforeach; ?>


                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($currentUser['fullname'] ?? '') ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ giao hàng</label>
                                <textarea name="shipping_address" class="form-control" rows="3"><?= old('shipping_address', $body) ?></textarea>
                                <div class="small text-danger mt-1"><?= form_error('shipping_address', $errors ?? []) ?></div>
                            </div>
                            <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Đặt hàng</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/user/layouts/Footer.php' ?>