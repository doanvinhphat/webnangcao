<?php
if (!defined('_INCODE')) die('Truy cập bị từ chối!');

$errors = [];
$body = getBody();

if (isPost()) {
    $email = trim($body['email']);

    if (empty(trim($email))) {
        $errors['email']['required'] = 'Vui lòng nhập email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email']['regex'] = 'Email không đúng định dạng';
    }

    // Nếu không có lỗi
    if (empty($errors)) {
        // Kiểm tra email trong hệ thống
        if (!checkExists('users', 'email', $email)) {
            $errors['email']['notFound'] = 'Email không tồn tại trong hệ thống';
        } else {
            // Nếu tồn tại thì sinh reset_token + reset_token_expire
            $token = bin2hex(random_bytes(32)); // token ngẫu nhiên
            $expire = date('Y-m-d H:i:s', strtotime('+1 hour')); // hết hạn sau 1h

            $dataUpdate = update('users', [
                'reset_token' => $token,
                'reset_token_expire' => $expire
            ], "email = '$email'");

            if ($dataUpdate) {
                // Tạo link reset
                $linkReset = BASE_URL . "/?module=auth&action=reset&token=" . $token;

                // Nội dung email
                $subject = "Yêu cầu đặt lại mật khẩu";
                $content = "
        <p>Xin chào,</p>
        <p>Bạn vừa yêu cầu đặt lại mật khẩu. Vui lòng click vào link bên dưới để tiếp tục:</p>
        <p><a href='$linkReset'>$linkReset</a></p>
        <p>Link có hiệu lực trong vòng 1 giờ.</p>
        <p>Hãy bỏ qua nếu không phải bạn yêu cầu!.</p>
    ";

                // Gửi mail
                if (sendMail($email, $subject, $content)) {
                    setFlashData('msg', 'Vui lòng kiểm tra email để đặt lại mật khẩu');
                    setFlashData('msg_type', 'success');
                } else {
                    $errors['email']['sendFail'] = 'Không thể gửi email. Vui lòng thử lại sau';
                }
            }
        }
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
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
    <title>Quên mật khẩu</title>
</head>

<body>
    <div class="container mt-5">
        <?php getMsg($msg, $msgType); ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <fieldset class="border p-4 rounded">
                    <legend class="float-none w-auto px-2">Đăng nhập</legend>
                    <form method="post">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Nhập email</label>
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                placeholder="Nhập email"
                                name="email" />
                            <?php echo form_error('email', $errors, '<span class="text-danger">', '</span>'); ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary mx-auto d-block">
                                Xác nhận
                            </button>
                        </div>
                        <!-- Link to Login -->
                        <div class="text-center mt-3">
                            <a href="?module=auth&action=login">Đăng nhập</a>
                        </div>
                    </form>
                </fieldset>
            </div>
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