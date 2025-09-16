<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Reset CSS-->
    <link
        rel="stylesheet"
        href="https://meyerweb.com/eric/tools/css/reset/reset.css" />
    <!--Bootstrap-->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css"
        integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <title>Cập nhật mật khẩu</title>
</head>

<?php

$errors = [];

// Lấy token từ URL
$token = isset($_GET['token']) ? $_GET['token'] : null;

if (!$token) {
    setFlashData('msg', 'Link không hợp lệ!');
    setFlashData('msg_type', 'danger');
    redirect('?module=auth&action=forgot');
}

// Kiểm tra token trong DB
$sql = "SELECT * FROM users WHERE reset_token = :token AND reset_token_expire > NOW() LIMIT 1";
$user = first($sql, ['token' => $token]);

if (!$user) {
    setFlashData('msg', 'Link không hợp lệ hoặc đã hết hạn!');
    setFlashData('msg_type', 'danger');
    redirect('?module=auth&action=forgot');
}

if (isPost()) {
    $body = getBody();

    // Validate password
    if (empty(trim($body['password']))) {
        $errors['password']['required'] = 'Vui lòng nhập mật khẩu';
    } elseif (strlen(trim($body['password'])) < 6) {
        $errors['password']['min'] = 'Mật khẩu phải ít nhất 6 ký tự';
    }

    if (empty(trim($body['confirmPassword']))) {
        $errors['confirmPassword']['required'] = 'Vui lòng nhập lại mật khẩu';
    } elseif (trim($body['password']) !== trim($body['confirmPassword'])) {
        $errors['confirmPassword']['compare'] = 'Nhập lại mật khẩu không đúng';
    }

    if (empty($errors)) {
        $password = password_hash($body['password'], PASSWORD_DEFAULT);

        // Update mật khẩu + clear token
        $dataUpdateStatus = update('users', [
            'password' => $password,
            'reset_token' => null,
            'reset_token_expire' => null
        ], "id = {$user['id']}");

        if ($dataUpdateStatus) {
            setFlashData('msg', 'Cập nhật mật khẩu thành công, vui lòng đăng nhập lại');
            setFlashData('msg_type', 'success');
            redirect('?module=auth&action=login');
        } else {
            setFlashData('msg', 'Lỗi hệ thống! Không thể cập nhật');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<body>
    <div class="container mt-5">
        <?php getMsg($msg, $msgType); ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <fieldset class="border p-4 rounded">
                    <legend class="float-none w-auto px-2">Cập nhật mật khẩu</legend>
                    <form method="post">
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                placeholder="Nhập mật khẩu"
                                name="password" />
                            <?php echo form_error('password', $errors, '<span class="text-danger">', '</span>'); ?>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
                            <input
                                type="password"
                                class="form-control"
                                id="confirmPassword"
                                placeholder="Nhập lại mật khẩu"
                                name="confirmPassword" />
                            <?php echo form_error('confirmPassword', $errors, '<span class="text-danger">', '</span>'); ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary mx-auto d-block">
                                Xác nhận
                            </button>
                        </div>
                    </form>
                </fieldset>
            </div>

        </div>

        <!--Bootstrap-->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js"
            integrity="sha512-HvOjJrdwNpDbkGJIG2ZNqDlVqMo77qbs4Me4cah0HoDrfhrbA+8SBlZn1KrvAQw7cILLPFJvdwIgphzQmMm+Pw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>
</body>

</html>