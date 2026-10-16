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

<!-- UI Form Nâng Cấp -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="mb-4 text-center text-primary fw-bold">
                        <i class="fa-solid fa-user-pen me-2"></i>Cập nhật thông tin cá nhân
                    </h3>

                    <?php if (!empty($errors['general']['db'])): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            <?php echo $errors['general']['db']; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="fa-solid fa-phone me-1 text-secondary"></i>Số điện thoại
                            </label>
                            <input type="text" class="form-control form-control-lg" id="phone" name="phone"
                                placeholder="Nhập số điện thoại của bạn"
                                value="<?php echo old('phone', $body, $currentUser['phone']); ?>">
                            <?php echo form_error('phone', $errors, '<div class="text-danger mt-1 small">', '</div>'); ?>
                        </div>

                        <!-- Avatar -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label fw-semibold">
                                <i class="fa-solid fa-image me-1 text-secondary"></i>Ảnh đại diện
                            </label>
                            <input type="file" class="form-control form-control-lg" id="avatar" name="avatar" accept="image/*">
                            <?php echo form_error('avatar', $errors, '<div class="text-danger mt-1 small">', '</div>'); ?>

                            <?php if (!empty($currentUser['avatar'])): ?>
                                <div class="mt-3 text-center">
                                    <img src="<?php echo htmlspecialchars($currentUser['avatar']); ?>" alt="Avatar"
                                        class="rounded-circle border border-3 border-primary shadow-sm"
                                        width="90" height="90">
                                    <p class="text-muted mt-2 small">Ảnh hiện tại của bạn</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">

                        <!-- Password Section -->
                        <h5 class="fw-bold text-secondary mb-3">
                            <i class="fa-solid fa-lock me-2"></i>Đổi mật khẩu
                        </h5>

                        <div class="mb-3">
                            <label for="old_password" class="form-label fw-semibold">Mật khẩu cũ</label>
                            <input type="password" class="form-control form-control-lg" id="old_password" name="old_password"
                                placeholder="Nhập mật khẩu cũ">
                            <?php echo form_error('old_password', $errors, '<div class="text-danger mt-1 small">', '</div>'); ?>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">Mật khẩu mới</label>
                            <input type="password" class="form-control form-control-lg" id="new_password" name="new_password"
                                placeholder="Nhập mật khẩu mới">
                            <?php echo form_error('new_password', $errors, '<div class="text-danger mt-1 small">', '</div>'); ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password"
                                placeholder="Nhập lại mật khẩu mới">
                            <?php echo form_error('confirm_password', $errors, '<div class="text-danger mt-1 small">', '</div>'); ?>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="fa-solid fa-floppy-disk me-1"></i>Cập nhật
                            </button>
                            <a href="?module=home&action=lists" class="btn btn-outline-secondary btn-lg fw-semibold">
                                <i class="fa-solid fa-house me-1"></i>Quay lại trang chủ
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome CDN -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-xh6O/CkQoQfTzCj1lA2aR2zqEXx4VgH14Q6gttxyPjdvVSkv5rH3g3R3HkJj7V0z0QzEPUWpo5E7L0FdsZ6Fzw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


<?php require_once 'templates/user/layouts/Footer.php' ?>