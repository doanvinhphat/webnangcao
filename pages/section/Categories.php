<?php 
$listCategories = getRows("SELECT * FROM categories");

?>

<!-- Categories -->
<div class="container my-2">
  <nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
      <!-- Hamburger -->
      <button class="navbar-toggler custom-toggler" type="button" aria-controls="categoryMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Danh mục -->
      <div class="collapse navbar-collapse justify-content-center" id="categoryMenu">
        <ul class="navbar-nav mb-2 mb-lg-0 d-flex flex-wrap justify-content-center">
          <?php foreach ($listCategories as $category): ?>
            <li class="nav-item">
              <a class="nav-link" href="?module=user&action=listbycategories&category=<?php echo htmlspecialchars($category['slug']); ?>">
                <?php echo htmlspecialchars($category['name']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </nav>
</div>

<style>
  .navbar-toggler.custom-toggler {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }

  /* Ẩn mặc định */
  #categoryMenu {
    display: none;
  }

  /* Khi mở */
  #categoryMenu.show {
    display: block;
  }

  @media (min-width: 768px) {
    #categoryMenu {
      display: flex !important; /* luôn hiện khi màn hình lớn */
    }
  }
</style>



