<?php
if (!defined('_INCODE')) die('Access denied...');

$errors = [];
$body = getBody();
$userId = $_SESSION['currentUser']['id'];

// Lấy thông tin user hiện tại (để show avatar cũ, phone cũ)
$currentUser = first("SELECT * FROM users WHERE id = :id", ['id' => $userId]);

if (isPost()) {
    // Validate phone
    $phone = trim($body['phone']);
    if (empty($phone)) {
        $errors['phone']['required'] = 'Vui lòng nhập số điện thoại';
    } elseif (!preg_match('/^0[0-9]{9}$/', $phone)) {
        $errors['phone']['regex'] = 'Số điện thoại không hợp lệ';
    } elseif ($phone !== $currentUser['phone'] && checkExists('users', 'phone', $phone)) {
        $errors['phone']['unique'] = 'Số điện thoại đã tồn tại';
    }

    // Validate password nếu có nhập
    if (!empty($body['old_password']) || !empty($body['new_password']) || !empty($body['confirm_password'])) {
        if (empty($body['old_password'])) {
            $errors['old_password']['required'] = 'Vui lòng nhập mật khẩu cũ';
        } elseif (!password_verify($body['old_password'], $currentUser['password'])) {
            $errors['old_password']['invalid'] = 'Mật khẩu cũ không đúng';
        }

        if (empty($body['new_password'])) {
            $errors['new_password']['required'] = 'Vui lòng nhập mật khẩu mới';
        } elseif (strlen($body['new_password']) < 6) {
            $errors['new_password']['min'] = 'Mật khẩu mới phải >= 6 ký tự';
        }

        if ($body['new_password'] !== $body['confirm_password']) {
            $errors['confirm_password']['match'] = 'Xác nhận mật khẩu không khớp';
        }
    }

    // Validate avatar (nếu có file)
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {
        $imgErrors = checkImage('avatar', true, 2 * 1024 * 1024); // 2MB
        if (!empty($imgErrors)) {
            $errors['avatar'] = $imgErrors;
        }
    }

    // Nếu không có lỗi thì update
    if (empty($errors)) {
        $dataUpdate = [
            'phone' => $phone,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Đổi mật khẩu nếu có
        if (!empty($body['new_password']) && empty($errors['old_password'])) {
            $dataUpdate['password'] = password_hash($body['new_password'], PASSWORD_DEFAULT);
        }

        // Xử lý avatar nếu upload mới
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $fileName = uniqid('avatar_', true) . '.' . $ext;
            $filePath = AVATAR_UPLOADS_PATH . '/' . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
                // Xóa ảnh cũ nếu có
                if (!empty($currentUser['avatar']) && file_exists(BASE_PATH . '/' . $currentUser['avatar'])) {
                    unlink(BASE_PATH . '/' . $currentUser['avatar']);
                }

                // Lưu đường dẫn tương đối
                $dataUpdate['avatar'] = 'public/uploads/avatars/' . $fileName;
            }
        }

        // Update DB
        if (update('users', $dataUpdate, "id=$userId")) {
            // Cập nhật lại session
            foreach ($dataUpdate as $key => $val) {
                $_SESSION['currentUser'][$key] = $val;
            }
            setFlashData('msg', 'Cập nhật thông tin thành công');
            setFlashData('msg_type', 'success');

            redirect('?module=home&action=lists');
        } else {
            setFlashData('msg', 'Cập nhật thất bại');
            setFlashData('msg_type', 'danger');
            redirect('?module=users&action=profile');
        }
    }
}

?>

<?php require_once 'templates/user/layouts/Header.php' ?>

<!-- UI Form -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-4 text-center">Cập nhật thông tin cá nhân</h3>

            <?php if (!empty($errors['general']['db'])): ?>
                <div class="alert alert-danger"><?php echo $errors['general']['db']; ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="<?php echo old('phone', $body, $currentUser['phone']); ?>">
                    <?php echo form_error('phone', $errors, '<span class="text-danger">', '</span>'); ?>
                </div>

                <!-- Avatar -->
                <div class="mb-3">
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                    <?php echo form_error('avatar', $errors, '<span class="text-danger">', '</span>'); ?>
                    <?php if (!empty($currentUser['avatar'])): ?>
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars($currentUser['avatar']); ?>" alt="Avatar"
                                class="rounded-circle" width="80" height="80">
                        </div>
                    <?php endif; ?>
                </div>

                <hr>

                <!-- Password change -->
                <div class="mb-3">
                    <label for="old_password" class="form-label">Mật khẩu cũ</label>
                    <input type="password" class="form-control" id="old_password" name="old_password">
                    <?php echo form_error('old_password', $errors, '<span class="text-danger">', '</span>'); ?>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                    <?php echo form_error('new_password', $errors, '<span class="text-danger">', '</span>'); ?>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <?php echo form_error('confirm_password', $errors, '<span class="text-danger">', '</span>'); ?>
                </div>

                <!-- Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a class="btn btn-info" href="?module=home&action=lists">Quay lại trang chủ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'templates/user/layouts/Footer.php' ?>