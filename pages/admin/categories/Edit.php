<?php
$errors = [];
$body = [];

// Lấy id danh mục cần sửa
$id = $_GET['id'] ?? null;
if (!$id) {
    setFlashData('msg', 'ID danh mục không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=categories&action=List');
}

// Lấy dữ liệu danh mục cũ
$category = first("SELECT * FROM categories WHERE id = :id", ['id' => $id]);
if (!$category) {
    setFlashData('msg', 'Danh mục không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=categories&action=List');
}

// Nếu chưa submit, gán dữ liệu cũ vào $body
$body = $category;

if (isPost()) {
    $body = getBody();

    // Validate tên danh mục
    if (empty(trim($body['name']))) {
        $errors['name']['required'] = 'Vui lòng nhập tên danh mục';
    }

    // Nếu không có lỗi
    if (empty($errors)) {
        $dataUpdate = [
            'name' => trim($body['name']),
            'slug' => createSlug($body['name']),
            'updated_by' => $_SESSION['currentUser']['id'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $updateStatus = update('categories', $dataUpdate, 'id = ' . $id);

        if ($updateStatus) {
            setFlashData('msg', 'Cập nhật danh mục thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&controller=categories&action=List');
        } else {
            setFlashData('msg', 'Cập nhật danh mục thất bại');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }
}
?>

<section class="container mt-4">
    <h1>Sửa danh mục</h1>

    <form method="post" class="mt-3">
        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" id="name" class="form-control"
                value="<?= old('name', $body) ?>">
            <?= form_error('name', $errors, '<span class="text-danger">', '</span>') ?>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="?module=admin&controller=categories&action=List" class="btn btn-secondary">Quay lại</a>
    </form>
</section>