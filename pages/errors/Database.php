<?php 

function showDatabaseError($errorMessage)
{
    $safeMessage = htmlspecialchars($errorMessage); // chống XSS

    echo '
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi Database</title>
    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reseter.css/2.0.0/reseter.min.css" integrity="sha512-gCJkkUMGTe73+FMwog6gIBCVJIMXRoc21l6/IPCuzxCex/1sxvO8ctb6Zd4/WWs2UMqmtnDrAdhJht5pEY0LXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL ?>/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Lỗi kết nối CSDL</h4>
            <p><b>Chi tiết:</b> ' . $safeMessage . '</p>
            <hr>
            <p class="mb-0"><small>Thời gian: ' . date("Y-m-d H:i:s") . '</small></p>
        </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" integrity="sha512-7rusk8kGPFynZWu26OKbTeI+QPoYchtxsmPeBqkHIEXJxeun4yJ4ISYe7C6sz9wdxeE1Gk3VxsIWgCZTc+vX3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo ASSETS_URL ?>/js/style.js?v=<?php echo time(); ?>"></script>
</body>
</html>
    ';
}
?>