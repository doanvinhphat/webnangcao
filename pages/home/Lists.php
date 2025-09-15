<?php 
$pageTitle = 'Trang chủ';

// $send = sendMail('doanvinhphat3004@gmail.com', 'Test email', 'Noi dung');

// if($send){
//     setFlashData('msg', 'Gửi email thành công!');
//     setFlashData('msg_type', 'success');
// } else {
//     setFlashData('msg', 'Hệ thống đang gặp sự cố. Vui lòng thử lại sau!');
//     setFlashData('msg_type', 'danger');
// }
?>
    <?php require_once 'templates/user/layouts/Header.php' ?>

<!-- ====== Banner Section ====== -->
<div class="container my-5">
  <div class="row g-3">
    <!-- Left Banner (CCTV Camera) -->
    <div class="col-lg-8">
      <div class="promo-card d-flex align-items-center justify-content-between">
        <div>
          <p class="text-muted mb-1">Big Sale Offer</p>
          <h3 class="fw-bold">Get the Best Deal on CCTV Camera</h3>
          <p class="text-secondary">
            Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor
            incididunt ut labore dolore magna aliqua.
          </p>
          <h5 class="fw-bold">
            Combo Only: <span class="text-dark">$590.00</span>
          </h5>
          <a href="#" class="btn btn-primary mt-3">Shop Now</a>
        </div>
        <div>
          <img
            src="https://pngimg.com/d/security_camera_PNG105.png"
            alt="CCTV Camera"
            class="promo-img"
          />
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4 d-flex flex-column gap-3">
      <!-- iPhone Card -->
      <div class="promo-card text-center">
        <p class="text-muted mb-1">New line required</p>
        <h5 class="fw-bold">iPhone 12 Pro Max</h5>
        <h5 class="text-primary fw-bold">$259.99</h5>
        <img
          src="https://fdn2.gsmarena.com/vv/pics/apple/apple-iphone-12-pro-max-1.jpg"
          alt="iPhone"
          class="promo-img mt-2"
        />
      </div>

      <!-- Weekly Sale -->
      <div class="promo-dark d-flex flex-column justify-content-between">
        <div>
          <h4 class="fw-bold">Weekly Sale!</h4>
          <p>Saving up to 50% off all online store items this week.</p>
        </div>
        <a href="#" class="btn btn-light mt-3">Shop Now</a>
      </div>
    </div>
  </div>
</div>

<!-- ====== Featured Categories Section ====== -->
<div class="container my-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Featured Categories</h2>
    <p class="text-muted">
      There are many variations of passages of Lorem Ipsum available, but the
      majority have suffered alteration in some form.
    </p>
  </div>
  <div class="row g-4">
    <!-- Category Item -->
    <div class="col-md-4">
      <div class="category-card d-flex justify-content-between align-items-center p-3 border rounded">
        <div>
          <h6 class="fw-bold">TV & Audios</h6>
          <ul class="list-unstyled small text-muted mb-0">
            <li>Smart Television</li>
            <li>QLED TV</li>
            <li>Audios</li>
            <li>Headphones</li>
            <li><a href="#" class="text-decoration-none">View All</a></li>
          </ul>
        </div>
        <img src="https://pngimg.com/d/headphones_PNG7650.png" alt="TV & Audios" class="img-fluid" style="max-width: 100px;">
      </div>
    </div>

    <div class="col-md-4">
      <div class="category-card d-flex justify-content-between align-items-center p-3 border rounded">
        <div>
          <h6 class="fw-bold">Desktop & Laptop</h6>
          <ul class="list-unstyled small text-muted mb-0">
            <li>Smart Television</li>
            <li>QLED TV</li>
            <li>Audios</li>
            <li>Headphones</li>
            <li><a href="#" class="text-decoration-none">View All</a></li>
          </ul>
        </div>
        <img src="https://www.pngall.com/wp-content/uploads/5/Mac-Pro-PNG-Image.png" alt="Desktop & Laptop" class="img-fluid" style="max-width: 100px;">
      </div>
    </div>

    <div class="col-md-4">
      <div class="category-card d-flex justify-content-between align-items-center p-3 border rounded">
        <div>
          <h6 class="fw-bold">CCTV Camera</h6>
          <ul class="list-unstyled small text-muted mb-0">
            <li>Smart Television</li>
            <li>QLED TV</li>
            <li>Audios</li>
            <li>Headphones</li>
            <li><a href="#" class="text-decoration-none">View All</a></li>
          </ul>
        </div>
        <img src="https://pngimg.com/d/security_camera_PNG105.png" alt="CCTV Camera" class="img-fluid" style="max-width: 100px;">
      </div>
    </div>

    <div class="col-md-4">
      <div class="category-card d-flex justify-content-between align-items-center p-3 border rounded">
        <div>
          <h6 class="fw-bold">DSLR Camera</h6>
          <ul class="list-unstyled small text-muted mb-0">
            <li>Smart Television</li>
            <li>QLED TV</li>
            <li>Audios</li>
            <li>Headphones</li>
            <li><a href="#" class="text-decoration-none">View All</a></li>
          </ul>
        </div>
        <img src="https://www.pngmart.com/files/22/DSLR-Camera-PNG-Isolated-Image.png" alt="DSLR Camera" class="img-fluid" style="max-width: 100px;">
      </div>
    </div>

    <div class="col-md-4">
      <div class="category-card d-flex justify-content-between align-items-center p-3 border rounded">
        <div>
          <h6 class="fw-bold">Smart Phones</h6>
          <ul class="list-unstyled small text-muted mb-0">
            <li>Smart Television</li>
            <li>QLED TV</li>
            <li>Audios</li>
            <li>Headphones</li>
            <li><a href="#" class="text-decoration-none">View All</a></li>
          </ul>
        </div>
        <img src="https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-note7-2.jpg" alt="Smart Phones" class="img-fluid" style="max-width: 100px;">
      </div>
    </div>

    <div class="col-md-4">
      <div class="category-card d-flex justify-content-between align-items-center p-3 border rounded">
        <div>
          <h6 class="fw-bold">Game Console</h6>
          <ul class="list-unstyled small text-muted mb-0">
            <li>Smart Television</li>
            <li>QLED TV</li>
            <li>Audios</li>
            <li>Headphones</li>
            <li><a href="#" class="text-decoration-none">View All</a></li>
          </ul>
        </div>
        <img src="https://www.pngmart.com/files/6/Game-Controller-PNG-Transparent-Image.png" alt="Game Console" class="img-fluid" style="max-width: 100px;">
      </div>
    </div>
  </div>
</div>

<style>
  .promo-card {
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    padding: 2rem;
    height: 100%;
  }
  .promo-dark {
    background-color: #06112a;
    color: #fff;
    border-radius: 0.5rem;
    padding: 2rem;
    height: 100%;
  }
  .promo-img {
    max-width: 100%;
    height: auto;
  }
  .category-card {
    transition: all 0.3s ease;
  }
  .category-card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transform: translateY(-5px);
  }
</style>

<?php require_once 'templates/user/layouts/Footer.php' ?>