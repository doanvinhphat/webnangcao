<?php
$errors = [];
$body = [];

// Lấy id sản phẩm cần sửa
$id = $_GET['id'] ?? null;
if (!$id) {
    setFlashData('msg', 'ID sản phẩm không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=products&action=List');
}

// Lấy dữ liệu sản phẩm cũ
$product = first("SELECT * FROM products WHERE id = :id", ['id' => $id]);
if (!$product) {
    setFlashData('msg', 'Sản phẩm không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=products&action=List');
}

// Nếu chưa submit, gán dữ liệu cũ vào $body
$body = $product;

if (isPost()) {
    $body = getBody();

    // Validate tên sản phẩm
    if (empty(trim($body['name']))) {
        $errors['name']['required'] = 'Vui lòng nhập tên sản phẩm';
    }

    // Validate mô tả
    if (empty(trim($body['description']))) {
        $errors['description']['required'] = 'Vui lòng nhập mô tả sản phẩm';
    }

    // Validate giá
    if (!checkNumber($body['price'], true)) {
        $errors['price']['invalid'] = 'Giá phải là số >= 0';
    }

    // Validate % giảm giá
    if (!checkNumber($body['discount_percent'], false)) {
        $errors['discount_percent']['invalid'] = '% giảm phải là số nguyên >= 0';
    }

    // Giá sau khi giảm
    $discountPrice = 0;
    if (empty($errors['price']) && empty($errors['discount_percent'])) {
        $discountPrice = $body['price'] - ($body['price'] * $body['discount_percent'] / 100);
    }

    // Validate stock
    if (!checkNumber($body['stock'], false)) {
        $errors['stock']['invalid'] = 'Số lượng tồn phải là số nguyên >= 0';
    }

    // Validate category_id
    if (empty($body['category_id'])) {
        $errors['category_id']['required'] = 'Vui lòng chọn danh mục';
    }

    // Validate ảnh (không bắt buộc)
    foreach (['image1', 'image2', 'image3'] as $imgField) {
        $imgErrors = checkImage($imgField, false, 2 * 1024 * 1024); // 2MB
        if (!empty($imgErrors)) {
            $errors[$imgField] = $imgErrors;
        }
    }

    if (empty($errors)) {
        $dataUpdate = [
            'name' => trim($body['name']),
            'slug' => createSlug($body['name']),
            'description' => trim($body['description']),
            'price' => $body['price'],
            'discount_percent' => $body['discount_percent'],
            'discount_price' => $discountPrice,
            'stock' => $body['stock'],
            'category_id' => $body['category_id'],
            'isActive' => isset($body['isActive']) ? 1 : 0,
            'updated_by' => $_SESSION['currentUser']['id'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Xử lý upload ảnh
        foreach (['image1', 'image2', 'image3'] as $imgField) {
            if (isset($_FILES[$imgField]) && $_FILES[$imgField]['error'] == UPLOAD_ERR_OK) {
                // Xóa ảnh cũ nếu tồn tại
                if (!empty($product[$imgField]) && file_exists($product[$imgField])) {
                    unlink($product[$imgField]);
                }

                $ext = strtolower(pathinfo($_FILES[$imgField]['name'], PATHINFO_EXTENSION));
                $fileName = uniqid('prod_', true) . '.' . $ext;
                $filePath = PRODUCT_UPLOADS_PATH . '/' . $fileName;

                if (move_uploaded_file($_FILES[$imgField]['tmp_name'], $filePath)) {
                    $dataUpdate[$imgField] = 'public/uploads/products/' . $fileName;
                }
            } else {
                // Giữ nguyên ảnh cũ
                $dataUpdate[$imgField] = $product[$imgField];
            }
        }

        $updateStatus = update('products', $dataUpdate, 'id = ' . $id);

        if ($updateStatus) {
            setFlashData('msg', 'Cập nhật sản phẩm thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&controller=products&action=List');
        } else {
            setFlashData('msg', 'Cập nhật sản phẩm thất bại');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }
}
?>

<div class="px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Sửa sản phẩm</h1>
        <a href="?module=admin&controller=products&action=List" class="btn btn-secondary">Quay lại</a>
    </div>

    <hr class="border border-3 border-dark">

    <form method="post" class="mt-3" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-lg-7">
                <!-- Tên sản phẩm -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold"><i class="bi bi-box-seam"></i> Tên sản phẩm</label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="Nhập tên sản phẩm..." value="<?= old('name', $body) ?>">
                    <div class="small text-danger mt-1"><?= form_error('name', $errors) ?></div>
                </div>

                <!-- Mô tả -->
    <div class="mb-3">
    <label for="description" class="form-label fw-bold">
        <i class="bi bi-card-text"></i> Mô tả
    </label>
    <textarea name="description" id="description" rows="5" class="form-control"
        placeholder="Nhập mô tả chi tiết..."><?= htmlspecialchars(html_entity_decode(old('description', $body))) ?></textarea>

    <div class="small text-danger mt-1"><?= form_error('description', $errors) ?></div>
</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold"><i class="bi bi-cash"></i> Giá gốc</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control"
                            value="<?= old('price', $body) ?>">
                        <div class="small text-danger mt-1"><?= form_error('price', $errors) ?></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold"><i class="bi bi-percent"></i> Giảm (%)</label>
                        <input type="number" name="discount_percent" id="discount_percent" class="form-control"
                            value="<?= old('discount_percent', $body, 0) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold"><i class="bi bi-cash-coin"></i> Giá sau giảm</label>
                        <input type="text" id="discount_price" class="form-control"
                            value="<?= old('discount_price', $body, 0) ?>" readonly>
                    </div>
                </div>

                <!-- Tình trạng active -->
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="1" name="isActive" id="isActive"
                        <?= (old('isActive', $body, $product['isActive']) == 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="isActive">
                        Kích hoạt sản phẩm
                    </label>
                </div>

            </div>

            <!-- Cột phải: Ảnh + stock + category -->
            <div class="col-lg-5">
                <label class="form-label fw-bold"><i class="bi bi-images"></i> Ảnh sản phẩm</label>
                <?php foreach (['image1', 'image2', 'image3'] as $imgField): ?>
                    <div class="mb-3">
                        <input class="form-control" type="file" name="<?= $imgField ?>" accept="image/*">
                        <?php if (!empty($product[$imgField])): ?>
                            <img src="<?= $product[$imgField] ?>" alt="" class="img-thumbnail mt-1" width="100">
                        <?php endif; ?>
                        <div class="small text-danger mt-1"><?= form_error($imgField, $errors) ?></div>
                    </div>
                <?php endforeach; ?>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-stack"></i> Tồn kho</label>
                        <input type="text" name="stock" class="form-control" value="<?= old('stock', $body, 0) ?>">
                        <div class="small text-danger mt-1"><?= form_error('stock', $errors) ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="bi bi-tags"></i> Danh mục</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Chọn danh mục --</option>
                            <?php
                            $categories = getRows("SELECT id, name FROM categories ORDER BY name ASC");
                            foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= (old('category_id', $body) == $cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="small text-danger mt-1"><?= form_error('category_id', $errors) ?></div>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Cập nhật</button>
                <a href="?module=admin&controller=products&action=List" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Hủy</a>
            </div>
            <!-- <?= htmlspecialchars_decode($product['description']) ?> -->
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const priceInput = document.getElementById("price");
        const discountInput = document.getElementById("discount_percent");
        const discountPriceInput = document.getElementById("discount_price");

        function updateDiscountPrice() {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const discountPrice = price - (price * discount / 100);
            discountPriceInput.value = discountPrice.toFixed(2);
        }

        priceInput.addEventListener("input", updateDiscountPrice);
        discountInput.addEventListener("input", updateDiscountPrice);
    });

    CKEDITOR.replace('description');
</script>