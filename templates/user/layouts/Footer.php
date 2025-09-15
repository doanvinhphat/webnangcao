<!-- Footer.php -->
<footer class="bg-dark text-light pt-5 pb-4">
  <div class="container">
    <div class="row align-items-center mb-4">
      <!-- Logo & Newsletter -->
      <div class="col-md-6 d-flex align-items-center mb-3 mb-md-0">
        <div class="me-3 d-flex align-items-center">
          <i class="bi bi-cart4 fs-2 text-primary"></i>
          <span class="fw-bold fs-4 ms-2">ShopGrids</span>
        </div>
        <div>
          <h6 class="fw-semibold mb-1">Subscribe to our Newsletter</h6>
          <small class="text-secondary">Get all the latest information, Sales and Offers.</small>
        </div>
      </div>
      <div class="col-md-6">
        <form class="d-flex">
          <input type="email" class="form-control me-2 newsletter-input" placeholder="Email address here..." required>
          <button type="submit" class="btn btn-primary px-4">Subscribe</button>
        </form>
      </div>
    </div>

    <hr class="border-secondary">

    <div class="row mt-4">
      <!-- Get In Touch -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-semibold footer-title">Get In Touch With Us</h6>
        <p class="mb-1">Phone: +1 (900) 33 169 7720</p>
        <p class="mb-1">Monday–Friday:<br>9.00 am – 8.00 pm</p>
        <p class="mb-1">Saturday:<br>10.00 am – 6.00 pm</p>
        <p class="mb-0">support@shopgrids.com</p>
      </div>

      <!-- Mobile App -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-semibold footer-title">Our Mobile App</h6>
        <a href="#" class="d-block btn btn-app mb-2">
          <i class="bi bi-apple me-2 fs-5"></i> Download on the App Store
        </a>
        <a href="#" class="d-block btn btn-app">
          <i class="bi bi-google-play me-2 fs-5"></i> Download on the Google Play
        </a>
      </div>

      <!-- Information -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-semibold footer-title">Information</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">About Us</a></li>
          <li><a href="#" class="footer-link">Contact Us</a></li>
          <li><a href="#" class="footer-link">Downloads</a></li>
          <li><a href="#" class="footer-link">Sitemap</a></li>
          <li><a href="#" class="footer-link">FAQs Page</a></li>
        </ul>
      </div>

      <!-- Shop Departments -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-semibold footer-title">Shop Departments</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">Computers & Accessories</a></li>
          <li><a href="#" class="footer-link">Smartphones & Tablets</a></li>
          <li><a href="#" class="footer-link">TV, Video & Audio</a></li>
          <li><a href="#" class="footer-link">Cameras, Photo & Video</a></li>
          <li><a href="#" class="footer-link">Headphones</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<!-- Custom CSS -->
<style>
  footer {
    background-color: #0d1b2a; /* xanh đậm */
  }
  .newsletter-input {
    background-color: #2b2d42;
    border: none;
    color: #fff;
  }
  .newsletter-input::placeholder {
    color: #aaa;
  }
  .footer-title {
    position: relative;
    padding-bottom: 8px;
    margin-bottom: 15px;
  }
  .footer-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 40px;
    height: 2px;
    background-color: #0d6efd;
  }
  .footer-link {
    color: #ccc;
    text-decoration: none;
    display: block;
    margin-bottom: 6px;
    transition: color 0.3s ease;
  }
  .footer-link:hover {
    color: #fff;
  }
  .btn-app {
    background-color: #1c1f2b;
    color: #fff;
    border: none;
    text-align: left;
    padding: 10px 15px;
    border-radius: 6px;
    transition: background 0.3s ease;
  }
  .btn-app:hover {
    background-color: #2c3145;
    color: #fff;
  }
</style>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ASSETS_URL ?>/js/style.js?v=<?php echo time(); ?>"></script>
</body>
</html>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo ASSETS_URL ?>/js/style.js?v=<?php echo time(); ?>"></script>
</body>
</html>