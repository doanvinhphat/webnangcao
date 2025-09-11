<?php 
$pageTitle = 'Trang chủ';

$send = sendMail('doanvinhphat3004@gmail.com', 'Test email', 'Noi dung');

if($send){
setMessage('success', 'Đăng ký thành công!');
} else {
    setMessage('danger', 'Đăng ký thất bại, vui lòng thử lại.');
}
?>

    <?php require_once 'templates/user/layouts/Header.php' ?>
    <div>
        Đây là phần body
    </div>

    <?php require_once 'templates/user/layouts/Footer.php' ?>
