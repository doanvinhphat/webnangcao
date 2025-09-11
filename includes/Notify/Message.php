<?php
$message = getMessage();
?>

<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
  <?php if (!empty($message)): ?>
    <div class="toast custom-toast text-bg-<?php echo $message['type']; ?> border-0 w-auto"
         role="alert" aria-live="assertive" aria-atomic="true" 
         data-bs-delay="4000">
      <div class="d-flex">
        <div class="toast-body">
          <strong>
            <?php 
              switch ($message['type']) {
                case 'success': echo "✅ Thành công! "; break;
                case 'danger':  echo "❌ Lỗi! "; break;
                case 'warning': echo "⚠️ Cảnh báo! "; break;
                case 'info':    echo "ℹ️ Thông tin! "; break;
              }
            ?>
          </strong>
          <?php echo htmlspecialchars($message['text']); ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
