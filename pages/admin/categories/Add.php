<?php
$errors = [];
$body = []; // dữ liệu cũ

if (isPost()) {
    $body = getBody();

    // Validate tên
    if (empty(trim($body['name']))) {
        $errors['name']['required'] = 'Vui lòng nhập tên danh mục';
    }

    // Nếu không có lỗi
    if (empty($errors)) {
        $dataInsert = [
            'name' => trim($body['name']),
            'slug' => createSlug($body['name']),
            'created_by' => $_SESSION['currentUser']['id']
        ];

        $insertStatus = insert('categories', $dataInsert);

        if ($insertStatus) {
            setFlashData('msg', 'Thêm danh mục thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&controller=categories&action=List');
        } else {
            setFlashData('msg', 'Thêm danh mục thất bại');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }
}

?>

<form method="post" class="mt-2">
    <div class="row g-2">
        <!-- Ô nhập + error -->
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" name="name" id="name" class="form-control"
                    placeholder="Nhập tên danh mục..."
                    value="<?= old('name', $body) ?>">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Thêm mới
                </button>
                <button type="reset" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Nhập lại
                </button>
            </div>
            <!-- Error luôn dưới input, không đẩy nút -->
            <div class="small mt-1 text-danger">
                <?= form_error('name', $errors, '', '') ?>
            </div>
        </div>
    </div>
</form>