<?php 
if(!defined('_INCODE')) die('Truy cập bị từ chối!');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//send gmail
function sendMail($to, $subject, $content)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'PhatDoan6969@gmail.com';                     //SMTP username
        $mail->Password   = 'mxeq lyvz qenz tnvc';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('PhatDoan6969@gmail.com', 'Vĩnh Phát');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->CharSet = 'UTF-8';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )

        );

        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//Kiểm tra phương thức POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }

    return false;
}

//Kiểm tra phương thức GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }

    return false;
}

//Lấy giá trị phương thức POST, GET
function getBody($method = '')
{

    $bodyArr = [];

    //if have method
    if (!$method) {
        if (isGet()) {
            //Xử lý chuỗi trước khi hiển thị ra
            //return $_GET;
            /*
             * Đọc key của mảng $_GET
             *
             * */
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //$bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                        $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //$bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                        $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if (isPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    } else {
        if ($method == 'get') {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        //$bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                        $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        //$bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                        $bodyArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        } else if ($method == 'post') {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }

    return $bodyArr;
}