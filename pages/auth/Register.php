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
  <title>Trang đăng ký</title>
</head>

<?php
$errors = [];
if (isPost()) {
  $body = getBody();

  if (empty(trim($body['fullname']))) {
    $errors['fullname']['required'] = 'Vui lòng nhập họ và tên';
  } elseif (strlen(trim($body['fullname'])) < 6) {
    $errors['fullname']['min'] = 'Họ và tên phải từ 6 ký tự trở lên';
  }

  if (empty(trim($body['email']))) {
    $errors['email']['required'] = 'Vui lòng nhập email';
  } elseif (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email']['regex'] = 'Email không đúng định dạng';
  } elseif (checkExists('users', 'email', $body['email'])) {
    $errors['email']['unique'] = 'Email đã tồn tại';
  }

  if (empty(trim($body['phone']))) {
    $errors['phone']['required'] = 'Vui lòng nhập phone';
  } elseif (!preg_match('/^0[0-9]{9}$/', $body['phone'])) {
    $errors['phone']['regex'] = 'Số điện thoại không hợp lệ';
  } elseif (checkExists('users', 'phone', $body['phone'])) {
    $errors['phone']['unique'] = 'Số điện thoại đã tồn tại';
  }

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
    // echo "<pre>";
    // print_r($body);
    // echo "</pre>";

    //hash password 
    $password = password_hash($body['password'], PASSWORD_DEFAULT);

    $dataInsert = [
      'fullname' => $body['fullname'],
      'email'    => $body['email'],
      'phone'    => $body['phone'],
      'password' => $password,
    ];

    // Thực hiện insert
    $insertStatus = insert('users', $dataInsert);

    if ($insertStatus) {
      setFlashData('msg', 'Đăng ký thành công');
      setFlashData('msg_type', 'success');

      redirect('?module=auth&action=login');
    } else {
      setFlashData('msg', 'Lỗi hệ thống! Bạn không thể đăng ký');
      setFlashData('msg_type', 'danger');
    }
  } else {
    setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
    setFlashData('msg_type', 'danger');
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
          <legend class="float-none w-auto px-2">Đăng ký</legend>
          <form method="post">
            <!-- Fullname -->
            <div class="mb-3">
              <label for="fullname" class="form-label">Họ và tên</label>
              <input
                type="text"
                class="form-control"
                id="fullname"
                placeholder="Nhập họ và tên"
                value="<?php echo old('fullname', $body) ?>"
                name="fullname" />
              <?php echo form_error('fullname', $errors, '<span class="text-danger">', '</span>'); ?>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="text"
                class="form-control"
                id="email"
                placeholder="Nhập email"
                value="<?php echo old('email', $body) ?>"
            
                name="email" />
              <?php echo form_error('email', $errors, '<span class="text-danger">', '</span>'); ?>
            </div>

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
                Đăng ký
              </button>
            </div>

            <!-- Login link -->
            <div class="text-center">
              <span>Bạn đã có tài khoản?</span>
              <a href="?module=auth&action=login" class="btn btn-link p-0 ms-1">Đăng nhập</a>
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