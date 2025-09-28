<?php
$errors = [];
$body = []; // dữ liệu cũ

$body = getBody();
if (isPost()) {

    // Validate code
    if (empty(trim($body['code']))) {
        $errors['code']['required'] = 'Vui lòng nhập mã voucher';
    }

    // Validate % giảm giá
    if (!checkNumber($body['discount_value'], false)) {
        $errors['discount_value']['invalid'] = '% giảm phải là số nguyên >= 0';
    }

    // Validate số lượng
    if (!checkNumber($body['quantity'], false)) {
        $errors['quantity']['invalid'] = 'Số lượng phải là số nguyên >= 0';
    }

    // Validate ngày
    if (empty($body['start_date'])) {
        $errors['start_date']['required'] = 'Vui lòng chọn ngày bắt đầu';
    }
    if (empty($body['end_date'])) {
        $errors['end_date']['required'] = 'Vui lòng chọn ngày kết thúc';
    }

    if (empty($errors)) {
        $dataInsert = [
            'code' => strtoupper(trim($body['code'])),
            'discount_value' => $body['discount_value'],
            'quantity' => $body['quantity'],
            'start_date' => $body['start_date'],
            'end_date' => $body['end_date'],
            'isActive' => !empty($body['isActive']) ? 1 : 0,
            'created_by' => $_SESSION['currentUser']['id'],
        ];

        $insertStatus = insert('vouchers', $dataInsert);

        if ($insertStatus) {
            setFlashData('msg', 'Thêm voucher thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&controller=vouchers&action=List');
        } else {
            setFlashData('msg', 'Thêm voucher thất bại');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }
}
?>

<div class="px-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Thêm voucher</h1>
    </div>

    <hr class="border border-3 border-dark">

    <form method="post" class="mt-3">
        <div class="row g-3">
            <!-- Mã voucher -->
            <div class="col-md-6">
                <label for="code" class="form-label fw-bold"><i class="bi bi-upc"></i> Mã voucher</label>
                <input type="text" name="code" id="code" class="form-control"
                    value="<?= old('code', $body) ?>" placeholder="Nhập mã voucher...">
                <div class="small text-danger mt-1"><?= form_error('code', $errors) ?></div>
            </div>

            <!-- % giảm -->
            <div class="col-md-3">
                <label class="form-label fw-bold"><i class="bi bi-percent"></i> Giảm (%)</label>
                <input type="number" name="discount_value" id="discount_value" class="form-control"
                    value="<?= old('discount_value', $body, 0) ?>">
                <div class="small text-danger mt-1"><?= form_error('discount_value', $errors) ?></div>
            </div>

            <!-- Số lượng -->
            <div class="col-md-3">
                <label class="form-label fw-bold"><i class="bi bi-123"></i> Số lượng</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                    value="<?= old('quantity', $body, 0) ?>">
                <div class="small text-danger mt-1"><?= form_error('quantity', $errors) ?></div>
            </div>

            <!-- Ngày bắt đầu -->
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-calendar-event"></i> Ngày bắt đầu</label>
                <input type="date" name="start_date" class="form-control"
                    value="<?= old('start_date', $body) ?>">
                <div class="small text-danger mt-1"><?= form_error('start_date', $errors) ?></div>
            </div>

            <!-- Ngày kết thúc -->
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-calendar-x"></i> Ngày kết thúc</label>
                <input type="date" name="end_date" class="form-control"
                    value="<?= old('end_date', $body) ?>">
                <div class="small text-danger mt-1"><?= form_error('end_date', $errors) ?></div>
            </div>

            <!-- Trạng thái -->
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-toggle-on"></i> Trạng thái</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" role="switch"
                        id="isActive" name="isActive" value="1"
                        <?= old('isActive', $body, 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="isActive">Kích hoạt</label>
                </div>
            </div>
        </div>

        <!-- Nút hành động -->
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Thêm mới
            </button>
            <a href="?module=admin&controller=vouchers&action=List" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>