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
  <title>Trang đăng nhập</title>
</head>

<?php
$errors = [];
$body = getBody();

if (isPost()) {
  $phone = trim($body['phone']);
  $password = trim($body['password']);

  // Validate phone
  if (empty($phone)) {
    $errors['phone']['required'] = 'Vui lòng nhập số điện thoại';
  } elseif (!preg_match('/^0[0-9]{9}$/', $phone)) {
    $errors['phone']['regex'] = 'Số điện thoại không hợp lệ';
  }

  // Validate password
  if (empty($password)) {
    $errors['password']['required'] = 'Vui lòng nhập mật khẩu';
  }

  // Nếu không có lỗi thì xử lý login
  if (empty($errors)) {
    $user = first("SELECT * FROM users WHERE phone = :phone LIMIT 1", ['phone' => $phone]);

    if ($user) {
      if (password_verify($password, $user['password'])) {
        // Lưu session
        $_SESSION['currentUser'] = [
          'id' => $user['id'],
          'fullname' => $user['fullname'],
          'email' => $user['email'],
          'phone' => $user['phone'],
          'avatar' => $user['avatar'],
          'role' => $user['role']
        ];

        // Chuyển hướng
        if ($_SESSION['currentUser']['role'] === "admin") {
          redirect('?module=admin');
        } else {
          redirect('?module=home&action=lists');
        }
        exit;
      } else {
        $errors['password']['match'] = 'Mật khẩu không đúng';
      }
    } else {
      $errors['phone']['notfound'] = 'Số điện thoại không tồn tại';
    }
  }
}

$old = getFlashData('old');
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<body>
  <div class="container mt-5">
    <?php getMsg($msg, $msgType); ?>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <fieldset class="border p-4 rounded">
          <legend class="float-none w-auto px-2">Đăng nhập</legend>
          <form method="post">
            <!-- Phone -->
            <div class="mb-3">
              <label for="phone" class="form-label">Số điện thoại</label>
              <input
                type="text"
                class="form-control"
                id="phone"
                placeholder="Nhập số điện thoại"
                value="<?php echo old('phone', $body) ?>"
                
                name="phone" />
              <?php echo form_error('phone', $errors, '<span class="text-danger">', '</span>'); ?>
            </div>

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

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-primary mx-auto d-block">
                Đăng nhập
              </button>
            </div>
            <!-- Link to Register -->
            <div class="text-center mt-3">
              <p>Bạn chưa có tài khoản?
                <a href="?module=auth&action=register">Đăng ký ngay</a>
              </p>
            </div>
            <!-- Link to Forgot -->
            <div class="text-center mt-3">
              <a href="?module=auth&action=forgot" class="text-decoration-none text-muted">Quên mật khẩu</a>
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