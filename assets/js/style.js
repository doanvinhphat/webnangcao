//đây là đoạn tự đóng thông báo toast:
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".toast").forEach((el) => {
    const toast = new bootstrap.Toast(el);
    toast.show();
  });
});
