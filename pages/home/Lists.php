<?php
$pageTitle = 'Trang chủ';
?>
<?php require_once 'templates/user/layouts/Header.php' ?>

<?php require_once 'pages/section/Categories.php' ?>

<?php require_once 'pages/section/Banner.php' ?>

<?php require_once 'pages/section/FeatureProducts.php' ?>

<?php require_once 'pages/section/BestSeller.php' ?>

<?php require_once 'pages/section/SliderPartner.php' ?>

<?php require_once 'pages/section/SliderBrand.php' ?>

<?php require_once 'templates/user/layouts/Footer.php' ?>

<script>
  //brand
  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 2, // Hiển thị 2 slide (mỗi slide có 2 logo)
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    speed: 1000,
  });

  //partner
  const swiperPartner = new Swiper(".partnerSwiper", {
    slidesPerView: 4, // Hiển thị 4 logo cùng lúc
    slidesPerGroup: 1, // Mỗi lần trượt qua 1 logo
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 4500,
      disableOnInteraction: false,
    },
    speed: 1000,
    breakpoints: {
      0: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      992: {
        slidesPerView: 4,
      }
    }
  });
</script>