<!-- Header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Website' ?></title>

  <!-- Reset CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reseter.css/2.0.0/reseter.min.css"
        integrity="sha512-gCJkkUMGTe73+FMwog6gIBCVJIMXRoc21l6/IPCuzxCex/1sxvO8ctb6Zd4/WWs2UMqmtnDrAdhJht5pEY0LXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Swiper  -->
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"
/>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL ?>/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<?php 
  $msg = getFlashData('msg');
  $msgType = getFlashData('msg_type'); 
  getMsg($msg, $msgType);
?>

<!-- Header -->
<nav class="bg-light border-bottom sticky-top">
  <div class="container">
    <div class="row align-items-center py-2 g-3">
      
      <!-- Logo -->
      <div class="col-12 col-md-2 d-flex justify-content-center">
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
          <i class="bi bi-globe2 me-2"></i> MyWebsite
        </a>
      </div>

      <!-- Search -->
      <div class="col-6 col-md-6">
        <form class="d-flex w-100" role="search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Tìm kiếm ..." aria-label="Search">
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>

      <!-- User -->
      <div class="col-6 col-md-4 d-flex justify-content-center justify-content-md-end">
        <?php if (!empty($_SESSION['currentUser'])): ?>
          <div class="d-flex align-items-center gap-3">
            <!-- Giỏ hàng -->
            <a href="?module=cart" class="btn btn-outline-secondary position-relative">
              <i class="bi bi-cart"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                3
              </span>
            </a>

            <!-- Avatar + Dropdown -->
            <div class="dropdown">
              <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
   id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
  <img src="<?php echo ASSETS_URL ?>/images/avatar.png"
       alt="avatar" class="rounded-circle me-2" width="32" height="32">
  <!-- Ẩn tên trên mobile, hiện tên từ md trở lên -->
  <span class="d-none d-md-inline">
    <?php echo htmlspecialchars($_SESSION['currentUser']['fullname']); ?>
  </span>
</a>
              <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="?module=user&action=profile"><i class="bi bi-person"></i> Đổi thông tin</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="?module=auth&action=logout"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
              </ul>
            </div>
          </div>
        <?php else: ?>
          <div class="d-flex gap-2 auth-buttons">
            <a href="?module=auth&action=login" class="btn btn-outline-primary">Đăng nhập</a>
            <a href="?module=auth&action=register" class="btn btn-primary">Đăng ký</a>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
