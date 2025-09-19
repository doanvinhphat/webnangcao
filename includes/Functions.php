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

//Hàm thông báo lỗi validate
function form_error($fieldName, $errors, $beforeHtml = '', $afterHtml = '')
{
    return (!empty($errors[$fieldName])) ? $beforeHtml . reset($errors[$fieldName]) . $afterHtml : null;
}

//Hàm tạo thông báo
function getMsg($msg, $type = 'success')
{
    if (!empty($msg)) {
        echo '
        <div class="container mt-3">
            <div class="alert alert-' . $type . ' alert-dismissible fade show shadow-sm rounded-3 auto-dismiss" 
                 role="alert" style="max-width: 600px; min-width: 300px; z-index: 1050; transform: translateX(-50%); left: 50%; top: 20px; position: fixed;">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var alerts = document.querySelectorAll(".auto-dismiss");
                alerts.forEach(function(alertEl) {
                    setTimeout(function() {
                        var alert = bootstrap.Alert.getOrCreateInstance(alertEl);
                        alert.close();
                    }, 3000);
                });
            });
        </script>';
    }
}

//Hàm hiển thị dữ liệu cũ
function old($fieldName, $oldData, $default = null)
{
    return (!empty($oldData[$fieldName])) ? htmlspecialchars($oldData[$fieldName]) : $default;
}

//Hàm chuyển hướng
function redirect($path = 'index.php', $fullUrl = false)
{
    if (empty($fullUrl)) {
        $url = BASE_URL  . '/' . $path;
    } else {
        $url = $path;
    }
    header("Location: $url");
    exit;
}

//hàm tạo slug
function createSlug($string)
{
    // Chuyển dấu tiếng Việt sang không dấu
    $str = mb_strtolower($string, 'UTF-8');

    $unicode = [
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ'
    ];

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }

    // Loại bỏ ký tự không phải chữ, số, khoảng trắng
    $str = preg_replace('/[^a-z0-9\s-]/', '', $str);

    // Thay khoảng trắng và nhiều dấu - bằng 1 dấu -
    $str = preg_replace('/[\s-]+/', '-', $str);

    // Xóa - ở đầu và cuối
    $str = trim($str, '-');

    return $str;
}

//kiểm tra số
function checkNumber($value, $allowFloat = false)
{
    // Xóa khoảng trắng 2 đầu
    $value = trim($value);

    // Nếu rỗng coi như không hợp lệ
    if ($value === '') {
        return false;
    }

    // Kiểm tra số
    if ($allowFloat) {
        // Cho phép số thực
        if (!is_numeric($value)) {
            return false;
        }
        if ((float)$value < 0) {
            return false;
        }
        return true;
    } else {
        // Chỉ cho số nguyên
        if (!ctype_digit($value)) {
            return false;
        }
        if ((int)$value < 0) {
            return false;
        }
        return true;
    }
}

// Hàm kiểm tra ảnh upload
// $fieldName = tên input file (vd: 'image1')
// $required = true thì bắt buộc phải có file
// $maxSize = dung lượng tối đa (bytes), mặc định 2MB
function checkImage($fieldName, $required = true, $maxSize = 2097152)
{
    $errors = [];

    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] == UPLOAD_ERR_NO_FILE) {
        if ($required) {
            $errors[] = 'Vui lòng chọn ảnh ' . $fieldName;
        }
    } else {
        $file = $_FILES[$fieldName];

        // Kiểm tra lỗi upload cơ bản
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Upload ảnh ' . $fieldName . ' thất bại';
        } else {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($ext, $allowed)) {
                $errors[] = 'Ảnh ' . $fieldName . ' chỉ chấp nhận jpg, jpeg, png, gif, webp';
            }

            if ($file['size'] > $maxSize) {
                $errors[] = 'Ảnh ' . $fieldName . ' vượt quá dung lượng cho phép (' . round($maxSize / 1048576, 2) . 'MB)';
            }
        }
    }

    return $errors; // Mảng lỗi, rỗng nếu hợp lệ
}

//hỗ trợ các action của admin
function buildUrl($controller, $action, $params = [], $module = 'admin')
{
    $url = "index.php?module={$module}&controller={$controller}&action={$action}";
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $url .= '&' . urlencode($key) . '=' . urlencode($value);
        }
    }
    return $url;
}

//phân trang
function renderPagination($currentPage, $totalPages, $perPage, $extraParams = [])
{
    if ($totalPages <= 1) return '';

    $queryStr = $_GET;
    unset($queryStr['page']); // bỏ page cũ

    $html = '<nav><ul class="pagination justify-content-end">';

    // Nút Previous
    $prevDisabled = $currentPage <= 1 ? ' disabled' : '';
    $queryStr['page'] = $currentPage - 1;
    $html .= '<li class="page-item' . $prevDisabled . '">
                <a class="page-link" href="?' . http_build_query($queryStr) . '">«</a>
              </li>';

    // Các trang
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i == $currentPage ? ' active' : '';
        $queryStr['page'] = $i;
        $html .= '<li class="page-item' . $active . '">
                    <a class="page-link" href="?' . http_build_query($queryStr) . '">' . $i . '</a>
                  </li>';
    }

    // Nút Next
    $nextDisabled = $currentPage >= $totalPages ? ' disabled' : '';
    $queryStr['page'] = $currentPage + 1;
    $html .= '<li class="page-item' . $nextDisabled . '">
                <a class="page-link" href="?' . http_build_query($queryStr) . '">»</a>
              </li>';

    $html .= '</ul></nav>';
    return $html;
}
