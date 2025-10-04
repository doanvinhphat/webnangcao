<!-- ====== Banner Section ====== -->
<div class="container my-5">
  <div class="row g-4">
    <!-- Left Banner (Carousel) -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
        <div id="bannerCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="5000">
          <div class="carousel-inner h-100">

            <!-- Slide 1 -->
            <div class="carousel-item active h-100">
              <div class="position-relative h-100">
                <img src="assets/img/slider-bg1.jpg" class="w-100 h-100 object-fit-cover" alt="Slide 1">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center p-5 text-white">
                </div>
              </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item h-100">
              <div class="position-relative h-100">
                <img src="assets/img/slider-bg2.jpg" class="w-100 h-100 object-fit-cover" alt="Slide 2">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center p-5 text-white">
                </div>
              </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item h-100">
              <div class="position-relative h-100">
                <img src="assets/img/slider-bg3.jpg" class="w-100 h-100 object-fit-cover" alt="Slide 3">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center p-5 text-white">
                </div>
              </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item h-100">
              <div class="position-relative h-100">
                <img src="assets/img/slider-bg4.jpg" class="w-100 h-100 object-fit-cover" alt="Slide 4">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center p-5 text-white">
                </div>
              </div>
            </div>
          </div>

          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4 d-flex flex-column gap-4">
      <!-- Top Card -->
      <div class="card border-0 shadow-lg overflow-hidden rounded-4 position-relative">
        <img src="assets/img/slider-bg5.jpg" class="w-100 h-100 object-fit-cover" alt="iPhone 12 Pro Max">
        <div class="card-img-overlay d-flex flex-column justify-content-center  text-white p-4">
        </div>
      </div>

      <!-- Bottom Card (new added) -->
      <div class="card border-0 shadow-lg overflow-hidden rounded-4 position-relative">
        <img src="assets/img/slider-bg6.jpg" class="w-100 h-100 object-fit-cover" alt="Weekly Sale">
        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-start bg-dark bg-opacity-40 text-white p-4">
          <h4 class="fw-bold mb-2">Weekly Sale!</h4>
          <p class="mb-3">Giảm giá tới 50% cho tất cả sản phẩm online trong tuần này.</p>
          <a href="#" class="btn btn-warning fw-semibold rounded-pill px-4 py-2">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .object-fit-cover {
    object-fit: cover;
  }
</style>