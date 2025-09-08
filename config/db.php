<!-- kết nối database -->
<?php
$host = "localhost";  // Laragon mặc định
$user = "root";       // User mặc định
$pass = "";           // Password 
$dbname = "ecommerce-phone";  

$conn = new mysqli($host, $user, $pass, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

echo 'Kết nối CSDL thành công!';
?>

