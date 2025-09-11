<?php 

function setMessage($type, $text) {
    $_SESSION['message'] = [
        'type' => $type,  // success | danger | warning | info
        'text' => $text
    ];
}

function getMessage() {
    if (isset($_SESSION['message'])) {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']); // xóa sau khi lấy
        return $msg;
    }
    return null;
}
