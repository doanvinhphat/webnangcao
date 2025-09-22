document.addEventListener("DOMContentLoaded", function () {
  const dropdownToggle = document.getElementById("userDropdown");
  const dropdown = new bootstrap.Dropdown(dropdownToggle, {
    autoClose: true // click ngoài sẽ tự đóng
  });

  dropdownToggle.addEventListener("click", function (e) {
    e.preventDefault(); // ngăn reload trang do href="#"
    dropdown.toggle();  // bật/tắt thủ công
  });
});