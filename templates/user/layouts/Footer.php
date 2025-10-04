<!-- Footer.php -->
<?php
// Lấy thông tin cài đặt site
$site_settings = getRows("SELECT * FROM site_settings LIMIT 1");
$site = !empty($site_settings) ? $site_settings[0] : [];

// Lấy danh mục
$listCategories = getRows("SELECT * FROM categories");
?>

<footer class="bg-dark text-light pt-5">
    <div class="container">
        <!-- Logo + Newsletter -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 d-flex align-items-center mb-3 mb-md-0">
                <i class="bi bi-cart4 fs-2 text-primary me-2"></i>
                <span class="fw-bold fs-4">MyWebsite</span>
                <div class="ms-3">
                    <h6 class="fw-semibold mb-1">Đăng ký để nhận thông báo mới</h6>
                    <small class="text-secondary">Cập nhật sản phẩm & khuyến mãi mới nhất.</small>
                </div>
            </div>
            <div class="col-md-6">
                <form class="d-flex">
                    <input type="email" class="form-control rounded-start" placeholder="Nhập email tại đây..." required>
                    <button type="submit" class="btn btn-primary px-4 rounded-end">Đăng ký</button>
                </form>
            </div>
        </div>

        <hr class="border-secondary">

        <!-- Footer Content -->
        <div class="row mt-4">
            <!-- Liên hệ -->
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">Liên hệ</h6>

                <?php if (!empty($site['hotline1'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-telephone-fill me-2"></i>
                        <?= htmlspecialchars($site['hotline1']) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($site['hotline2'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-telephone me-2"></i>
                        <?= htmlspecialchars($site['hotline2']) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($site['working_hours'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-clock me-2"></i>
                        <?= htmlspecialchars($site['working_hours']) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($site['email'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <?= htmlspecialchars($site['email']) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($site['address'])): ?>
                    <p class="mb-0">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        <?= htmlspecialchars($site['address']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Ứng dụng -->
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">Mobile App</h6>
                <a href="#" class="btn btn-outline-light w-100 mb-2 text-start">
                    <i class="bi bi-apple me-2 fs-5"></i> App Store
                </a>
                <a href="#" class="btn btn-outline-light w-100 text-start">
                    <i class="bi bi-google-play me-2 fs-5"></i> Google Play
                </a>
            </div>

            <!-- Thông tin -->
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">Theo dõi chúng tôi</h6>
                <ul class="list-unstyled">
                    <?php if (!empty($site['facebook_link'])): ?>
                        <li><a href="<?php echo htmlspecialchars($site['facebook_link']); ?>" target="_blank" class="footer-link text-secondary d-block mb-2"><i class="bi bi-facebook me-1"></i> Facebook</a></li>
                    <?php endif; ?>
                    <?php if (!empty($site['instagram_link'])): ?>
                        <li><a href="<?php echo htmlspecialchars($site['instagram_link']); ?>" target="_blank" class="footer-link text-secondary d-block mb-2"><i class="bi bi-instagram me-1"></i> Instagram</a></li>
                    <?php endif; ?>
                    <?php if (!empty($site['youtube_link'])): ?>
                        <li><a href="<?php echo htmlspecialchars($site['youtube_link']); ?>" target="_blank" class="footer-link text-secondary d-block mb-2"><i class="bi bi-youtube me-1"></i> Youtube</a></li>
                    <?php endif; ?>
                    <?php if (!empty($site['twitter_link'])): ?>
                        <li><a href="<?php echo htmlspecialchars($site['twitter_link']); ?>" target="_blank" class="footer-link text-secondary d-block"><i class="bi bi-twitter me-1"></i> Twitter</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Danh mục -->
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">Danh mục</h6>
                <ul class="list-unstyled">
                    <?php foreach ($listCategories as $category): ?>
                        <li>
                            <a href="?module=user&action=listbycategories&category=<?php echo htmlspecialchars($category['slug']); ?>"
                                class="footer-link text-secondary d-block mb-2">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <hr class="border-secondary mt-4">

        <!-- Social + Copyright -->
        <div class="d-flex justify-content-center align-items-center pt-3">
            <p class="mb-0 small text-secondary">&copy; <?php echo date("Y"); ?> MyWebsite. All rights reserved.</p>
        </div>
    </div>
</footer>

</html>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!-- Sqiper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
<!--Custom JS -->
<script src="<?php echo ASSETS_URL ?>/js/style.js?v=<?php echo time(); ?>"></script>
</body>

</html>