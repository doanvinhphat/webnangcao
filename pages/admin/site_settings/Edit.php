<?php
$errors = [];
$body = [];

// Lấy id danh mục cần sửa
$id = $_GET['id'] ?? null;
if (!$id) {
    setFlashData('msg', 'ID không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=site_settings&action=List');
}

// Lấy dữ liệu cấu hình
$site_settings = first("SELECT * FROM site_settings WHERE id = :id", ['id' => $id]);
if (!$site_settings) {
    setFlashData('msg', 'Cấu hình không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=site_settings&action=List');
}

if (isPost()) {
    $body = getBody();

    // Hotline validate (giữ nguyên như bạn có)
    if (empty(trim($body['hotline1']))) {
        $errors['hotline1']['required'] = 'Vui lòng nhập hotline 1';
    } elseif (!preg_match('/^0[0-9]{9}$/', $body['hotline1'])) {
        $errors['hotline1']['regex'] = 'Số điện thoại không hợp lệ';
    }

    if (empty(trim($body['hotline2']))) {
        $errors['hotline2']['required'] = 'Vui lòng nhập hotline 2';
    } elseif (!preg_match('/^0[0-9]{9}$/', $body['hotline2'])) {
        $errors['hotline2']['regex'] = 'Số điện thoại không hợp lệ';
    }

    // Email validate
    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'Vui lòng nhập email';
    } elseif (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email']['regex'] = 'Email không đúng định dạng';
    }

    if (empty(trim($body['address']))) {
        $errors['address']['required'] = 'Vui lòng nhập địa chỉ';
    }

    if (empty(trim($body['working_hours']))) {
        $errors['working_hours']['required'] = 'Vui lòng nhập giờ làm việc';
    }

    // Social links validate (cho phép để trống, nếu có thì check URL)
    $socialFields = ['facebook_link', 'instagram_link', 'youtube_link', 'twitter_link'];
    foreach ($socialFields as $field) {
        if (!empty(trim($body[$field])) && !filter_var($body[$field], FILTER_VALIDATE_URL)) {
            $errors[$field]['url'] = ucfirst(str_replace('_', ' ', $field)) . ' không hợp lệ';
        }
    }

    if (empty($errors)) {
        $dataUpdate = [
            'hotline1'       => trim($body['hotline1']),
            'hotline2'       => trim($body['hotline2']),
            'email'          => trim($body['email']),
            'address'        => trim($body['address']),
            'working_hours'  => trim($body['working_hours']),
            'facebook_link'  => trim($body['facebook_link']),
            'instagram_link' => trim($body['instagram_link']),
            'youtube_link'   => trim($body['youtube_link']),
            'twitter_link'   => trim($body['twitter_link']),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $updateStatus = update('site_settings', $dataUpdate, 'id = ' . $id);

        if ($updateStatus) {
            setFlashData('msg', 'Cập nhật thông tin thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&controller=site_settings&action=List');
        } else {
            setFlashData('msg', 'Cập nhật thông tin thất bại');
            setFlashData('msg_type', 'danger');
        }
    }
}

$body = $site_settings;
?>

<section class="px-3">
    <div class="card border-0">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Cập nhật cấu hình</h1>
        </div>
        <hr class="border border-3 border-dark">

        <div class="card-body p-4">
            <form method="post" class="row g-4">

                <div class="col-md-6">
                    <label for="hotline1" class="form-label fw-semibold">
                        <i class="bi bi-telephone-fill me-1"></i> Hotline 1
                    </label>
                    <input type="text" name="hotline1" id="hotline1" class="form-control"
                        placeholder="Nhập số hotline chính"
                        value="<?= old('hotline1', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="hotline2" class="form-label fw-semibold">
                        <i class="bi bi-telephone me-1"></i> Hotline 2
                    </label>
                    <input type="text" name="hotline2" id="hotline2" class="form-control"
                        placeholder="Nhập số hotline phụ"
                        value="<?= old('hotline2', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">
                        <i class="bi bi-envelope-fill me-1"></i> Email
                    </label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="contact@example.com"
                        value="<?= old('email', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="address" class="form-label fw-semibold">
                        <i class="bi bi-geo-alt-fill me-1"></i> Địa chỉ
                    </label>
                    <input type="text" name="address" id="address" class="form-control"
                        placeholder="Nhập địa chỉ công ty"
                        value="<?= old('address', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="facebook_link" class="form-label fw-semibold">
                        <i class="bi bi-facebook me-1"></i> Facebook
                    </label>
                    <input type="url" name="facebook_link" id="facebook_link" class="form-control"
                        placeholder="https://facebook.com/yourpage"
                        value="<?= old('facebook_link', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="instagram_link" class="form-label fw-semibold">
                        <i class="bi bi-instagram me-1"></i> Instagram
                    </label>
                    <input type="url" name="instagram_link" id="instagram_link" class="form-control"
                        placeholder="https://instagram.com/yourpage"
                        value="<?= old('instagram_link', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="youtube_link" class="form-label fw-semibold">
                        <i class="bi bi-youtube me-1"></i> Youtube
                    </label>
                    <input type="url" name="youtube_link" id="youtube_link" class="form-control"
                        placeholder="https://youtube.com/yourchannel"
                        value="<?= old('youtube_link', $body) ?>">
                </div>

                <div class="col-md-6">
                    <label for="twitter_link" class="form-label fw-semibold">
                        <i class="bi bi-twitter me-1"></i> Twitter
                    </label>
                    <input type="url" name="twitter_link" id="twitter_link" class="form-control"
                        placeholder="https://twitter.com/yourpage"
                        value="<?= old('twitter_link', $body) ?>">
                </div>

                <div class="col-12">
                    <label for="working_hours" class="form-label fw-semibold">
                        <i class="bi bi-clock-fill me-1"></i> Thời gian làm việc
                    </label>
                    <input type="text" name="working_hours" id="working_hours" class="form-control"
                        placeholder="Ví dụ: 08:00 - 17:30, Thứ 2 - Thứ 6"
                        value="<?= old('working_hours', $body) ?>">
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="?module=admin&controller=site_settings&action=List" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Cập nhật
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>