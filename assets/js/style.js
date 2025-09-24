
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
