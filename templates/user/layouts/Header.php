
<!-- Header.php -->
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Website' ?></title>
    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reseter.css/2.0.0/reseter.min.css" integrity="sha512-gCJkkUMGTe73+FMwog6gIBCVJIMXRoc21l6/IPCuzxCex/1sxvO8ctb6Zd4/WWs2UMqmtnDrAdhJht5pEY0LXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL ?>/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<?php 
  $msg = getFlashData('msg');
  $msgType = getFlashData('msg_type'); 

  // echo $msg.'<br />';
  // echo $msgType.'<br />';

  getMsg($msg, $msgType)
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="#">MyWebsite</a>

    <!-- Nút toggle khi thu nhỏ màn hình -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" 
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nội dung -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Menu bên trái -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Giới thiệu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Liên hệ</a>
        </li>
      </ul>

      <!-- Nút đăng nhập/đăng ký bên phải -->
      <div class="form-inline my-2 my-lg-0">
        <a href="?module=auth&action=login" class="btn btn-outline-primary mr-2">Đăng nhập</a>
        <a href="?module=auth&action=login" class="btn btn-primary">Đăng ký</a>
      </div>
    </div>
  </div>
</nav>
