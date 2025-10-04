<?php
if (isGet()) {
    $body = getBody('get');
    $keyword = trim($body['keyword'] ?? '');

    if (!empty($keyword)) {
        // Tìm tất cả sản phẩm có tên gần đúng
        $sql = "SELECT * FROM products WHERE name LIKE ? AND isActive = 1";
        $products = getRows($sql, ["%" . $keyword . "%"]);

        if (!empty($products)) {
            if (count($products) == 1) {
                // Nếu chỉ có 1 kết quả thì redirect sang detail
                redirect("?module=user&action=detail&slug=" . $products[0]['slug']);
                exit;
            } else {
                // Nếu nhiều kết quả → load trang hiển thị danh sách
                require_once __DIR__ . '/SearchResult.php';
                exit;
            }
        } else {
            require_once PAGE_PATH . '/user/SearchEmpty.php';
            exit;
        }
    } else {
        require_once PAGE_PATH . '/user/SearchEmpty.php';
        exit;
    }
}
