<?php
// Lấy id sản phẩm cần xóa
$id = $_GET['id'] ?? null;

if (!$id) {
    setFlashData('msg', 'ID sản phẩm không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect(buildUrl('products', 'List'));
}

// Kiểm tra sản phẩm có tồn tại
$product = first("SELECT * FROM products WHERE id = :id", ['id' => $id]);
if (!$product) {
    setFlashData('msg', 'Sản phẩm không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect(buildUrl('products', 'List'));
}

// Xóa ảnh sản phẩm nếu tồn tại
foreach (['image1', 'image2', 'image3'] as $imgField) {
    if (!empty($product[$imgField]) && file_exists($product[$imgField])) {
        unlink($product[$imgField]);
    }
}

// Thực hiện xóa sản phẩm
$deleteStatus = delete('products', "id = $id");

if ($deleteStatus) {
    setFlashData('msg', 'Xóa sản phẩm thành công');
    setFlashData('msg_type', 'success');
} else {
    setFlashData('msg', 'Xóa sản phẩm thất bại');
    setFlashData('msg_type', 'danger');
}

// Quay về danh sách
redirect(buildUrl('products', 'List'));
