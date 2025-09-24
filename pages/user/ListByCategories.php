<?php
// Lấy slug từ URL
$slug = $_GET['category'] ?? null;

//echo 'Đã lấy được slug: '.$slug;

if($slug){
    //lấy thông tin
    $category = getRows("SELECT * FROM categories WHERE slug = ?", [$slug]);

    if (!empty($category)) {
        $categoryId = $category[0]['id'];

        // Lấy danh sách sản phẩm thuộc danh mục
        $products = getRows("SELECT * FROM products WHERE category_id = ?", [$categoryId]);
    }else{
        require_once PAGE_PATH.'/errors/404.php';
    }
}else{
    redirect('?module=home&action=lists');
}

// echo '<pre>';
// print_r($products);
// echo '</pre>';

?>
<?php require_once 'templates/user/layouts/Header.php' ?>

<div class="container my-4">
  <div class="row g-4">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <div class="col-md-3 col-sm-6">
          <div class="card h-100 shadow-sm">
            <a href="?module=user&action=detail&slug=<?php echo htmlspecialchars($product['slug']); ?>" 
               class="text-decoration-none text-dark">
               
              <!-- Ảnh sản phẩm -->
              <div class="ratio ratio-4x3">
                <img src="<?php echo htmlspecialchars($product['image1']); ?>" 
                     class="card-img-top object-fit-contain p-2" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>">
              </div>
              
              <div class="card-body">
                <!-- Tên sản phẩm -->
                <h6 class="card-title text-truncate">
                  <?php echo htmlspecialchars($product['name']); ?>
                </h6>
                
                <!-- Giá -->
                <div class="d-flex align-items-baseline justify-content-between mb-2">
                  <!-- Giá giảm -->
                  <strong class="text-danger fs-6">
                    <?= number_format($product['discount_price'] ?? $product['price'], 0, ',', '.') ?>₫
                  </strong>

                  <?php if ($product['discount_percent'] > 0): ?>
                    <div class="position-relative">
                      <span class="text-muted text-decoration-line-through small">
                        <?= number_format($product['price'], 0, ',', '.') ?>₫
                      </span>
                      <!-- % giảm (dấu mũ nhỏ ở góc) -->
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-muted border">
                        -<?= $product['discount_percent'] ?>%
                      </span>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Mô tả ngắn -->
                
<p class="card-text small text-muted">
  <?php 
    // Loại bỏ toàn bộ thẻ HTML (như <p>, <br>, <strong>, ...)
    $desc = strip_tags($product['description']); 
    
    // Giới hạn ký tự và thêm "..."
    echo mb_strlen($desc) > 60 ? mb_substr($desc, 0, 60) . '...' : $desc;
  ?>
</p>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-warning">Không có sản phẩm nào trong danh mục này.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once 'templates/user/layouts/Footer.php' ?>
