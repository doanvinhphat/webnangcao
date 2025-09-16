<?php

try{
    //kiểm tra PDO 
    if(class_exists('PDO')){
        $dsn = _DRIVER.':dbname='._DB.';host='._HOST;
        
        $option= [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // CSDL hỗ trợ utf8
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //bắt lỗi truy vấn
        ];
        
        $conn = new PDO($dsn, _USER, _PASS, $option);

// Set timezone MySQL theo VN
        $conn->exec("SET time_zone = '+07:00'");

        //var_dump($conn);
    }
}catch(Exception $e){
    require_once 'pages/errors/Database.php';
    die();
}

//PDO: PHP Data Object