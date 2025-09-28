<?php 
if(!defined('_INCODE')) die('Truy cập bị từ chối!');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lỗi kết nối CSDL</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-danger" style="max-width: 600px; width: 100%;">
        <div class="card-header bg-danger text-white text-center">
            <h4 class="mb-0">🚨 Lỗi kết nối CSDL</h4>
        </div>
        <div class="card-body text-center">
            <p class="text-muted">Thông tin chi tiết lỗi:</p>
            <div class="alert alert-danger text-start">
                <strong>Message:</strong> <?php echo $e->getMessage(); ?><br>
                <strong>File:</strong> <?php echo $e->getFile(); ?><br>
                <strong>Line:</strong> <?php echo $e->getLine(); ?>
            </div>
            <?php if (!$_SESSION['currentUser']['role'] === 'admin') { ?>
                    <a href="index.php" class="btn btn-primary mt-3">Quay lại trang chủ</a>
                <?php } ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" integrity="sha512-7rusk8kGPFynZWu26OKbTeI+QPoYchtxsmPeBqkHIEXJxeun4yJ4ISYe7C6sz9wdxeE1Gk3VxsIWgCZTc+vX3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>