<?php
require_once PAGE_PATH.'/errors/Database.php';

//thông tin kết nối 
const _HOST = 'localhost';
const _USER = 'root';
const _PASS = '';
const _DB = 'ecommerce-phone123';
const _DRIVER = 'mysql';

try{
    //kiểm tra PDO 
    if(class_exists('PDO')){
        $dsn = _DRIVER.':dbname='._DB.';host='._HOST;
        
        $option= [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // CSDL hỗ trợ utf8
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //bắt lỗi truy vấn
        ];
        
        $conn = new PDO($dsn, _USER, _PASS, $option);
        //var_dump($conn);
    }
}catch(Exception $exception){
    showDatabaseError($exception->getMessage());
    
    die();
}

//PDO: PHP Data Object