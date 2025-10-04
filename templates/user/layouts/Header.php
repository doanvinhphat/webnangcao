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
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Swiper  -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css" />

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL ?>/css/style.css?v=<?php echo time(); ?>">
</head>

<body>
  <?php
  $avatar = !empty($_SESSION['currentUser']['avatar'])
    ? $_SESSION['currentUser']['avatar']
    : 'https://cdn-icons-png.flaticon.com/128/3177/3177440.png';

  $msg = getFlashData('msg');
  $msgType = getFlashData('msg_type');
  getMsg($msg, $msgType);
  ?>
  <main class="flex-grow-1">

    <!-- Header -->
    <nav class="bg-light border-bottom sticky-top">
      <div class="container">
        <div class="row align-items-center py-2 g-3">

          <!-- Logo -->
          <div class="col-12 col-md-2 d-flex justify-content-center">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="?module=home&action=lists">
              <i class="bi bi-cart4 fs-2 text-primary me-2"></i>
              <span class="fw-bold fs-4">MyWebsite</span>
            </a>
          </div>

          <!-- Search -->
          <div class="col-6 col-md-6">
            <form class="d-flex w-100" role="search" method="get" action="">
              <input type="hidden" name="module" value="user">
              <input type="hidden" name="action" value="search">
              <div class="input-group">
                <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                  class="form-control" placeholder="Tìm kiếm ..." aria-label="Search">
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
                <div class="cart-wrapper position-relative">
                  <a href="#" id="cartToggle" class="btn btn-outline-secondary position-relative">
                    <i class="bi bi-cart"></i>
                    <?php
                    $cartCount = 0;
                    if (!empty($_SESSION['cart'])) {
                      foreach ($_SESSION['cart'] as $item) {
                        $cartCount += $item['qty'];
                      }
                    }
                    ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      <?= $cartCount ?>
                    </span>
                  </a>

                  <!-- Dropdown giỏ hàng -->
                  <div id="cartDropdown" class="cart-dropdown shadow-lg p-3 bg-white rounded position-absolute end-0 mt-2" style="display: none; min-width: 320px; z-index:1000;">
                    <?php if (!empty($_SESSION['cart'])): ?>
                      <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="d-flex align-items-center mb-2">
                          <img src="<?= htmlspecialchars($item['image']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>"
                            style="width: 50px; height: 50px; object-fit: cover;"
                            class="me-2 rounded border">
                          <div class="flex-grow-1">
                            <div class="fw-semibold small"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="text-muted small">
                              SL: <?= $item['qty'] ?> × <?= number_format($item['price'], 0, ',', '.') ?>₫
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>

                      <hr>
                      <a href="?module=user&action=checkout" class="btn btn-success w-100">
                        Tiến hành thanh toán
                      </a>
                    <?php else: ?>
                      <div class="text-center text-muted small">Giỏ hàng trống</div>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Avatar + Dropdown -->
                <div class="dropdown">
                  <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $avatar; ?>"
                      alt="avatar" class="rounded-circle me-2" width="32" height="32">
                    <!-- Ẩn tên trên mobile, hiện tên từ md trở lên -->
                    <span class="d-none d-md-inline">
                      <?php echo htmlspecialchars($_SESSION['currentUser']['fullname']); ?>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li>
                      <a class="dropdown-item" href="?module=user&action=profile">
                        <i class="bi bi-person"></i> Đổi thông tin
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="?module=user&action=orders">
                        <i class="bi bi-bag"></i> Đơn hàng của bạn
                      </a>
                    </li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li>
                      <a class="dropdown-item text-danger" href="?module=auth&action=logout">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                      </a>
                    </li>
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
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>