<?php
// Lấy id danh mục cần xóa
$id = $_GET['id'] ?? null;

if (!$id) {
    setFlashData('msg', 'ID danh mục không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect(buildUrl('categories', 'List'));
}

// Kiểm tra danh mục có tồn tại
$category = first("SELECT * FROM categories WHERE id = :id", ['id' => $id]);
if (!$category) {
    setFlashData('msg', 'Danh mục không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect(buildUrl('categories', 'List'));
}

// Thực hiện xóa
$deleteStatus = delete('categories', "id = $id");

if ($deleteStatus) {
    setFlashData('msg', 'Xóa danh mục thành công');
    setFlashData('msg_type', 'success');
} else {
    setFlashData('msg', 'Xóa danh mục thất bại');
    setFlashData('msg_type', 'danger');
}

// Quay về danh sách
redirect(buildUrl('categories', 'List'));
