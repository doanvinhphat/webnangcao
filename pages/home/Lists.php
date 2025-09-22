<?php 
$pageTitle = 'Trang chủ';
?>
<?php require_once 'templates/user/layouts/Header.php' ?>

<!-- Categories -->
<div class="container my-2">
  <nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
      <!-- Hamburger (chỉ hiện trên mobile) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#categoryMenu" aria-controls="categoryMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Danh mục -->
      <div class="collapse navbar-collapse" id="categoryMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-wrap">
          <li class="nav-item">
            <a class="nav-link" href="?category=vivo">Vivo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?category=oppo">Oppo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?category=samsung">Samsung</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?category=realme">Realme</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?category=iphone">iPhone</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?category=xiaomi">Xiaomi</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<!-- ====== Banner Section ====== -->
<div class="container my-5">
  <div class="row g-4">
    <!-- Left Banner (CCTV Camera Slider) -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg h-100 overflow-hidden">
        <div
          id="bannerCarousel"
          class="carousel slide h-100"
          data-bs-ride="carousel"
          data-bs-interval="5000"
        >
          <div class="carousel-inner h-100">
            <!-- Slide 1 -->
            <div class="carousel-item active h-100">
              <div
                class="position-relative d-flex flex-column justify-content-center align-items-start h-100 p-5 text-white"
                style="
                  background: url('https://demo.graygrids.com/themes/shopgrids/assets/images/hero/slider-bg1.jpg')
                    center/cover no-repeat;
                "
              >
                <!-- Overlay -->
                <div
                  class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
                ></div>
                <!-- Content -->
                <div class="position-relative">
                  <p class="text-uppercase small fw-semibold">Big Sale Offer</p>
                  <h3 class="fw-bold">Get the Best Deal on CCTV Camera</h3>
                  <p class="mb-3">
                    Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod
                    tempor incididunt.
                  </p>
                  <h5 class="fw-bold mb-3">
                    Combo Only: <span class="text-warning">$590.00</span>
                  </h5>
                  <a href="#" class="btn btn-primary">Shop Now</a>
                </div>
              </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item h-100">
              <div
                class="position-relative d-flex flex-column justify-content-center align-items-start h-100 p-5 text-white"
                style="
                  background: url('https://demo.graygrids.com/themes/shopgrids/assets/images/hero/slider-bg1.jpg')
                    center/cover no-repeat;
                "
              >
                <div
                  class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
                ></div>
                <div class="position-relative">
                  <p class="text-uppercase small fw-semibold">Hot Deal</p>
                  <h3 class="fw-bold">Exclusive Smart CCTV Package</h3>
                  <p class="mb-3">
                    High-resolution cameras with night vision and remote
                    monitoring.
                  </p>
                  <h5 class="fw-bold mb-3">
                    Only: <span class="text-warning">$699.00</span>
                  </h5>
                  <a href="#" class="btn btn-success">Order Now</a>
                </div>
              </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item h-100">
              <div
                class="position-relative d-flex flex-column justify-content-center align-items-start h-100 p-5 text-white"
                style="
                  background: url('https://demo.graygrids.com/themes/shopgrids/assets/images/hero/slider-bg1.jpg')
                    center/cover no-repeat;
                "
              >
                <div
                  class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
                ></div>
                <div class="position-relative">
                  <p class="text-uppercase small fw-semibold">Limited Time</p>
                  <h3 class="fw-bold">CCTV with Free Installation</h3>
                  <p class="mb-3">
                    Get a professional installation service free with this
                    combo.
                  </p>
                  <h5 class="fw-bold mb-3">
                    Starting at: <span class="text-warning">$499.00</span>
                  </h5>
                  <a href="#" class="btn btn-warning text-dark">Grab Deal</a>
                </div>
              </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item h-100">
              <div
                class="position-relative d-flex flex-column justify-content-center align-items-start h-100 p-5 text-white"
                style="
                  background: url('https://demo.graygrids.com/themes/shopgrids/assets/images/hero/slider-bg1.jpg')
                    center/cover no-repeat;
                "
              >
                <div
                  class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
                ></div>
                <div class="position-relative">
                  <p class="text-uppercase small fw-semibold">
                    Special Collection
                  </p>
                  <h3 class="fw-bold">Premium CCTV Solutions</h3>
                  <p class="mb-3">
                    Modern designs, advanced technology, and unbeatable prices.
                  </p>
                  <h5 class="fw-bold mb-3">
                    Starting at: <span class="text-warning">$799.00</span>
                  </h5>
                  <a href="#" class="btn btn-light">Explore Now</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Controls -->
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#bannerCarousel"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#bannerCarousel"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon"></span>
          </button>

          <!-- Indicators -->
          <div class="carousel-indicators">
            <button
              type="button"
              data-bs-target="#bannerCarousel"
              data-bs-slide-to="0"
              class="active"
            ></button>
            <button
              type="button"
              data-bs-target="#bannerCarousel"
              data-bs-slide-to="1"
            ></button>
            <button
              type="button"
              data-bs-target="#bannerCarousel"
              data-bs-slide-to="2"
            ></button>
            <button
              type="button"
              data-bs-target="#bannerCarousel"
              data-bs-slide-to="3"
            ></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4 d-flex flex-column gap-4">
      <!-- iPhone Card -->
      <div class="card text-white border-0 shadow-lg overflow-hidden">
        <div class="ratio ratio-4x3">
          <img
            src="https://demo.graygrids.com/themes/shopgrids/assets/images/hero/slider-bnr.jpg"
            class="card-img"
            alt="iPhone Banner"
            style="object-fit: cover"
          />
        </div>
        <div
          class="card-img-overlay d-flex flex-column justify-content-center bg-dark bg-opacity-50 p-3 rounded"
        >
          <p class="text-uppercase small mb-1">New Line Required</p>
          <h5 class="fw-bold">iPhone 12 Pro Max</h5>
          <h5 class="text-warning fw-bold">$259.99</h5>
        </div>
      </div>

      <!-- Weekly Sale -->
      <div class="card bg-dark text-white border-0 shadow-lg h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <h4 class="fw-bold">Weekly Sale!</h4>
            <p class="mb-0">
              Save up to 50% off all online store items this week.
            </p>
          </div>
          <a href="#" class="btn btn-light mt-3 align-self-start">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ====== Danh mục nổi bật Section ====== -->
<div class="container my-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Danh mục nổi bật</h2>
    <p class="text-muted">1 số Danh mục nổi bật</p>
  </div>
  <div class="row g-4">
    <!-- Category Item -->
    <div class="col-md-4">
      <div
        class="category-card d-flex justify-content-between align-items-center p-3 border rounded"
      >
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
        <img
          src="https://pngimg.com/d/headphones_PNG7650.png"
          alt="TV & Audios"
          class="img-fluid"
          style="max-width: 100px"
        />
      </div>
    </div>
    <div class="col-md-4">
      <div
        class="category-card d-flex justify-content-between align-items-center p-3 border rounded"
      >
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
        <img
          src="https://pngimg.com/d/headphones_PNG7650.png"
          alt="TV & Audios"
          class="img-fluid"
          style="max-width: 100px"
        />
      </div>
    </div>
    <div class="col-md-4">
      <div
        class="category-card d-flex justify-content-between align-items-center p-3 border rounded"
      >
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
        <img
          src="https://pngimg.com/d/headphones_PNG7650.png"
          alt="TV & Audios"
          class="img-fluid"
          style="max-width: 100px"
        />
      </div>
    </div>
    <div class="col-md-4">
      <div
        class="category-card d-flex justify-content-between align-items-center p-3 border rounded"
      >
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
        <img
          src="https://pngimg.com/d/headphones_PNG7650.png"
          alt="TV & Audios"
          class="img-fluid"
          style="max-width: 100px"
        />
      </div>
    </div>
    <div class="col-md-4">
      <div
        class="category-card d-flex justify-content-between align-items-center p-3 border rounded"
      >
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
        <img
          src="https://pngimg.com/d/headphones_PNG7650.png"
          alt="TV & Audios"
          class="img-fluid"
          style="max-width: 100px"
        />
      </div>
    </div>
    <div class="col-md-4">
      <div
        class="category-card d-flex justify-content-between align-items-center p-3 border rounded"
      >
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
        <img
          src="https://pngimg.com/d/headphones_PNG7650.png"
          alt="TV & Audios"
          class="img-fluid"
          style="max-width: 100px"
        />
      </div>
    </div>
  </div>
</div>

  <!-- ====== Sản phẩm thịnh hành Section ====== -->
  <div class="container my-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Sản phẩm thịnh hành</h2>
      <p class="text-muted">các sản phẩm thịnh hành hiện nay</p>
    </div>

    <div class="row g-4">
      <!-- Product Item -->
      <div class="col-md-3">
        <div class="card product-card h-100 border-0 shadow-sm">
          <div class="position-relative overflow-hidden text-center p-3">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-1.jpg"
              class="card-img-top img-fluid"
              alt="Xiaomi Mi Band 5"
            />
            <span class="badge bg-success position-absolute top-0 start-0 m-2"
              >Hot</span
            >
            <div class="product-overlay">
              <button class="btn btn-sm btn-primary me-2">
                <i class="bi bi-cart"></i> Add
              </button>
              <button class="btn btn-sm btn-outline-light">
                <i class="bi bi-heart"></i>
              </button>
            </div>
          </div>
          <div class="card-body text-center">
            <p class="text-muted small mb-1">Watches</p>
            <h6 class="fw-bold">Xiaomi Mi Band 5</h6>
            <div class="mb-1">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star text-warning"></i>
              <span class="text-muted small">(4.0)</span>
            </div>
            <h6 class="text-primary fw-bold">$199.00</h6>
          </div>
        </div>
      </div>

      <!-- Product Item -->
      <div class="col-md-3">
        <div class="card product-card h-100 border-0 shadow-sm">
          <div class="position-relative overflow-hidden text-center p-3">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-2.jpg"
              class="card-img-top img-fluid"
              alt="Speaker"
            />
            <span class="badge bg-danger position-absolute top-0 start-0 m-2"
              >-25%</span
            >
            <div class="product-overlay">
              <button class="btn btn-sm btn-primary me-2">
                <i class="bi bi-cart"></i> Add
              </button>
              <button class="btn btn-sm btn-outline-light">
                <i class="bi bi-heart"></i>
              </button>
            </div>
          </div>
          <div class="card-body text-center">
            <p class="text-muted small mb-1">Speaker</p>
            <h6 class="fw-bold">Big Power Sound Speaker</h6>
            <div class="mb-1">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <span class="text-muted small">(5.0)</span>
            </div>
            <h6 class="text-primary fw-bold">
              $275.00
              <span class="text-muted text-decoration-line-through fs-6"
                >$300.00</span
              >
            </h6>
          </div>
        </div>
      </div>

      <!-- Product Item -->
      <div class="col-md-3">
        <div class="card product-card h-100 border-0 shadow-sm">
          <div class="position-relative overflow-hidden text-center p-3">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-3.jpg"
              class="card-img-top img-fluid"
              alt="WiFi Security Camera"
            />
            <div class="product-overlay">
              <button class="btn btn-sm btn-primary me-2">
                <i class="bi bi-cart"></i> Add
              </button>
              <button class="btn btn-sm btn-outline-light">
                <i class="bi bi-heart"></i>
              </button>
            </div>
          </div>
          <div class="card-body text-center">
            <p class="text-muted small mb-1">Camera</p>
            <h6 class="fw-bold">WiFi Security Camera</h6>
            <div class="mb-1">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <span class="text-muted small">(5.0)</span>
            </div>
            <h6 class="text-primary fw-bold">$399.00</h6>
          </div>
        </div>
      </div>

      <!-- Product Item -->
      <div class="col-md-3">
        <div class="card product-card h-100 border-0 shadow-sm">
          <div class="position-relative overflow-hidden text-center p-3">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-4.jpg"
              class="card-img-top img-fluid"
              alt="iPhone 6x plus"
            />
            <span class="badge bg-primary position-absolute top-0 start-0 m-2"
              >New</span
            >
            <div class="product-overlay">
              <button class="btn btn-sm btn-primary me-2">
                <i class="bi bi-cart"></i> Add
              </button>
              <button class="btn btn-sm btn-outline-light">
                <i class="bi bi-heart"></i>
              </button>
            </div>
          </div>
          <div class="card-body text-center">
            <p class="text-muted small mb-1">Phones</p>
            <h6 class="fw-bold">iPhone 6x plus</h6>
            <div class="mb-1">
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <i class="bi bi-star-fill text-warning"></i>
              <span class="text-muted small">(5.0)</span>
            </div>
            <h6 class="text-primary fw-bold">$400.00</h6>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ====== Ưu đãi đặc biệt Section ====== -->
  <div class="container my-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Ưu đãi đặc biệt</h2>
      <p class="text-muted">Các Ưu đãi đặc biệt</p>
    </div>

    <div class="row g-4">
      <!-- Product Item -->
      <div class="col-md-3">
        <div class="product-card border rounded p-3 h-100">
          <div class="text-center">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-3.jpg"
              class="img-fluid"
              alt="WiFi Security Camera"
            />
          </div>
          <p class="text-muted small mb-1">Camera</p>
          <h6 class="fw-bold">WiFi Security Camera</h6>
          <div class="mb-1">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <span class="text-muted small">5.0 Review(s)</span>
          </div>
          <h6 class="text-primary fw-bold">$399.00</h6>
        </div>
      </div>

      <!-- Product Item -->
      <div class="col-md-3">
        <div class="product-card border rounded p-3 h-100">
          <div class="text-center">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-8.jpg"
              class="img-fluid"
              alt="Apple MacBook Air"
            />
          </div>
          <p class="text-muted small mb-1">Laptop</p>
          <h6 class="fw-bold">Apple MacBook Air</h6>
          <div class="mb-1">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <span class="text-muted small">5.0 Review(s)</span>
          </div>
          <h6 class="text-primary fw-bold">$899.00</h6>
        </div>
      </div>

      <!-- Product Item -->
      <div class="col-md-3">
        <div class="product-card border rounded p-3 h-100">
          <div class="text-center">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/products/product-6.jpg"
              class="img-fluid"
              alt="Bluetooth Speaker"
            />
          </div>
          <p class="text-muted small mb-1">Speaker</p>
          <h6 class="fw-bold">Bluetooth Speaker</h6>
          <div class="mb-1">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star text-warning"></i>
            <span class="text-muted small">4.0 Review(s)</span>
          </div>
          <h6 class="text-primary fw-bold">$70.00</h6>
        </div>
      </div>

      <!-- Product Item -->
      <div class="col-md-3">
        <div class="product-card border rounded p-3 h-100 position-relative">
          <span class="badge bg-danger position-absolute top-0 end-0 m-2"
            >-50%</span
          >
          <div class="text-center">
            <img
              src="https://demo.graygrids.com/themes/shopgrids/assets/images/offer/offer-image.jpg"
              class="img-fluid"
              alt="Bluetooth Headphone"
            />
          </div>
          <h6 class="fw-bold mt-2">Bluetooth Headphone</h6>
          <div class="mb-1">
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <span class="text-muted small">5.0 Review(s)</span>
          </div>
          <h6 class="text-primary fw-bold">
            $200.00
            <span class="text-muted text-decoration-line-through fs-6"
              >$400.00</span
            >
          </h6>
          <p class="small text-muted">
            Lorem Ipsum is simply dummy text of the printing and typesetting
            industry incididunt ut.
          </p>
        </div>
      </div>
    </div>

    <!-- Bottom Banner -->
    <div class="row mt-4">
      <div class="col-md-6">
        <div
          class="p-4 bg-light border rounded h-100 d-flex justify-content-end align-items-center text-white"
          style="
            background: url('https://demo.graygrids.com/themes/shopgrids/assets/images/banner/banner-3-bg.jpg')
              no-repeat center center;
            background-size: cover;
          "
        >
          <div class="bg-dark bg-opacity-50 p-3 rounded">
            <h5 class="fw-bold">Samsung Notebook 9</h5>
            <p class="small mb-2">laptop mới nhất thuộc series Ultrabook 9</p>

            <h6 class="fw-bold">$590.00</h6>
            <a href="#" class="btn btn-primary btn-sm">Shop Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div
          class="p-4 bg-light border rounded h-100 d-flex justify-content-end align-items-center text-white"
          style="
            background: url('https://demo.graygrids.com/themes/shopgrids/assets/images/banner/banner-3-bg.jpg')
              no-repeat center center;
            background-size: cover;
          "
        >
          <div class="bg-dark bg-opacity-50 p-3 rounded">
            <h5 class="fw-bold">Samsung Notebook 9</h5>
            <p class="small mb-2">laptop mới nhất thuộc series Ultrabook 9</p>

            <h6 class="fw-bold">$590.00</h6>
            <a href="#" class="btn btn-primary btn-sm">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Logo Brand Slider -->
<section id="Logobrand" class="py-5 bg-light">
  <div class="container text-center">
    <h5 class="mb-4">Thương hiệu phổ biến</h5>

    <!-- Swiper container -->
<div class="swiper mySwiper">
  <div class="swiper-wrapper">
    <!-- Slide 1 -->
    <div class="swiper-slide">
      <div class="row justify-content-center">
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/01.png"
               class="img-fluid d-block mx-auto" alt="Brand 1">
        </div>
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/02.png"
               class="img-fluid d-block mx-auto" alt="Brand 2">
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="swiper-slide">
      <div class="row justify-content-center">
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/03.png"
               class="img-fluid d-block mx-auto" alt="Brand 3">
        </div>
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/04.png"
               class="img-fluid d-block mx-auto" alt="Brand 4">
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="swiper-slide">
      <div class="row justify-content-center">
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/05.png"
               class="img-fluid d-block mx-auto" alt="Brand 5">
        </div>
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/06.png"
               class="img-fluid d-block mx-auto" alt="Brand 6">
        </div>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="swiper-slide">
      <div class="row justify-content-center">
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/07.png"
               class="img-fluid d-block mx-auto" alt="Brand 7">
        </div>
        <div class="col-6 col-sm-6">
          <img src="https://demo.graygrids.com/themes/shopgrids/assets/images/brands/08.png"
               class="img-fluid d-block mx-auto" alt="Brand 8">
        </div>
      </div>
    </div>
  </div>

</div>
  </div>
</section>


  <?php require_once 'templates/user/layouts/Footer.php' ?>
<script>
  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 2,   // Hiển thị 2 slide (mỗi slide có 2 logo)
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
  });
</script>
