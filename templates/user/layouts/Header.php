
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
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-primary" href="#">
      <i class="bi bi-globe2 me-2"></i> MyWebsite
    </a>

    <!-- Nút toggle khi thu nhỏ màn hình -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nội dung -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Menu bên trái -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Giới thiệu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Liên hệ</a>
        </li>
      </ul>

      <?php if (!empty($_SESSION['currentUser'])): ?>
  <!-- Đã đăng nhập -->
  <div class="d-flex align-items-center gap-3">
    <!-- Giỏ hàng -->
    <a href="?module=cart" class="btn btn-outline-secondary position-relative">
      <i class="bi bi-cart"></i>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        3 <!-- số lượng sp, bạn thay động -->
      </span>
    </a>

          <!-- Avatar + Dropdown -->
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" 
         id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?php echo ASSETS_URL ?>/images/avatar.png" 
             alt="avatar" class="rounded-circle me-2" width="32" height="32">
        <span><?php echo htmlspecialchars($_SESSION['currentUser']['fullname']); ?></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="?module=user&action=profile"><i class="bi bi-person"></i> Đổi thông tin</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="?module=auth&action=logout"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
      </ul>
    </div>
  </div>
<?php else: ?>
  <!-- Chưa đăng nhập -->
  <div class="d-flex gap-2">
    <a href="?module=auth&action=login" class="btn btn-outline-primary">Đăng nhập</a>
    <a href="?module=auth&action=register" class="btn btn-primary">Đăng ký</a>
  </div>
<?php endif; ?>

    </div>
  </div>
</nav>
