<?php
if (!isset($_SESSION['currentUser'])) {
    redirect('?module=auth&action=login');
}
$contentFile = include __DIR__ . '/index.php';
//echo 'Chào mừng: ' . $_SESSION['currentUser']['fullname'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Reset CSS-->
    <link
        rel="stylesheet"
        href="https://meyerweb.com/eric/tools/css/reset/reset.css" />
    <!--Bootstrap-->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css"
        integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <!--Fontawesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL ?>/css/style.css?v=<?php echo time(); ?>">
    <title>Trang Quản Trị</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 sidebar p-0">
                <?php include "Sidebar.php"; ?>
            </div>
            <!-- Main content -->
            <div class="col-10 p-0">
                <?php include "Navbar.php"; ?>
                <div class="p-4">
                    <?php include $contentFile; ?>
                </div>
            </div>
        </div>
    </div>

    <!--Bootstrap-->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js"
        integrity="sha512-HvOjJrdwNpDbkGJIG2ZNqDlVqMo77qbs4Me4cah0HoDrfhrbA+8SBlZn1KrvAQw7cILLPFJvdwIgphzQmMm+Pw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
</body>

</html>