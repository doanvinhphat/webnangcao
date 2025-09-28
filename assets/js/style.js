
/* Header */
document.addEventListener("DOMContentLoaded", function () {
  const dropdownToggle = document.getElementById("userDropdown");
  if (dropdownToggle) {
    const dropdown = new bootstrap.Dropdown(dropdownToggle, {
      autoClose: true
    });

    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault();
      dropdown.toggle();
    });
  }
});

/* Categories */
document.addEventListener("DOMContentLoaded", function () {
    const toggler = document.querySelector(".custom-toggler");
    const menu = document.getElementById("categoryMenu");
    if(toggler && menu){
      toggler.addEventListener("click", function () {
        menu.classList.toggle("show");
  
        // toggle trạng thái cho accessibility
        if (menu.classList.contains("show")) {
          toggler.setAttribute("aria-expanded", "true");
        } else {
          toggler.setAttribute("aria-expanded", "false");
        }
      });
    }
});

  // Thay đổi ảnh chính khi click vào thumbnail
document.querySelectorAll('.thumbnail-img').forEach(img => {
    img.addEventListener('click', function() {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = this.src;
    });
});

//giỏ hàng ấn- hiện
document.addEventListener("DOMContentLoaded", function() {
  const toggleBtn = document.getElementById("cartToggle");
  const dropdown  = document.getElementById("cartDropdown");

  toggleBtn.addEventListener("click", function(e) {
    e.preventDefault();
    dropdown.style.display = (dropdown.style.display === "none" || dropdown.style.display === "") 
      ? "block" 
      : "none";
  });

  // Click ra ngoài thì đóng dropdown
  document.addEventListener("click", function(e) {
    if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.style.display = "none";
    }
  });
});

//đặt hàng
document.getElementById('place_order_form').addEventListener('submit', function(e){
    var voucherSelect = document.getElementById('voucher_select');
    var voucherHidden = document.getElementById('voucher_code_hidden');
    voucherHidden.value = voucherSelect.value;
});
