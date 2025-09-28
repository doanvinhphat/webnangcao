<?php
$errors = [];
$body = [];

// Lấy id voucher cần sửa
$id = $_GET['id'] ?? null;
if (!$id) {
    setFlashData('msg', 'ID voucher không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=vouchers&action=List');
}

// Lấy dữ liệu voucher cũ
$voucher = first("SELECT * FROM vouchers WHERE id = :id", ['id' => $id]);
if (!$voucher) {
    setFlashData('msg', 'Voucher không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=vouchers&action=List');
}

// Nếu chưa submit, gán dữ liệu cũ vào $body
$body = $voucher;

if (isPost()) {
    $body = getBody();

    // Validate code
    if (empty(trim($body['code']))) {
        $errors['code']['required'] = 'Vui lòng nhập mã voucher';
    }

    // Validate giá trị giảm (%)
    if (!checkNumber($body['discount_value'], false)) {
        $errors['discount_value']['invalid'] = 'Giá trị giảm phải là số nguyên >= 0';
    }

    // Validate số lượng
    if (!checkNumber($body['quantity'], false)) {
        $errors['quantity']['invalid'] = 'Số lượng phải là số nguyên >= 0';
    }

    // Validate ngày bắt đầu & ngày kết thúc
    if (empty($body['start_date'])) {
        $errors['start_date']['required'] = 'Vui lòng chọn ngày bắt đầu';
    }
    if (empty($body['end_date'])) {
        $errors['end_date']['required'] = 'Vui lòng chọn ngày kết thúc';
    } elseif (!empty($body['start_date']) && $body['end_date'] < $body['start_date']) {
        $errors['end_date']['invalid'] = 'Ngày kết thúc phải sau ngày bắt đầu';
    }

    if (empty($errors)) {
        $dataUpdate = [
            'code' => trim($body['code']),
            'discount_value' => (int)$body['discount_value'],
            'quantity' => (int)$body['quantity'],
            'start_date' => $body['start_date'],
            'end_date' => $body['end_date'],
            'isActive' => $body['isActive'] ?? 0,
            'updated_by' => $_SESSION['currentUser']['id'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $updateStatus = update('vouchers', $dataUpdate, 'id = ' . $id);

        if ($updateStatus) {
            setFlashData('msg', 'Cập nhật voucher thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&controller=vouchers&action=List');
        } else {
            setFlashData('msg', 'Cập nhật voucher thất bại');
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
        <h1>Cập nhật voucher</h1>
        <a href="?module=admin&controller=vouchers&action=List" class="btn btn-secondary">Quay lại</a>
    </div>

    <hr class="border border-3 border-dark">

    <form method="post" class="mt-3">
        <div class="row g-3">
            <div class="col-lg-6">
                <!-- Mã voucher -->
                <div class="mb-3">
                    <label for="code" class="form-label fw-bold"><i class="bi bi-ticket"></i> Mã voucher</label>
                    <input type="text" name="code" id="code" class="form-control"
                        value="<?= old('code', $body) ?>" placeholder="Nhập mã voucher...">
                    <div class="small text-danger mt-1"><?= form_error('code', $errors) ?></div>
                </div>

                <!-- Giá trị giảm -->
                <div class="mb-3">
                    <label for="discount_value" class="form-label fw-bold"><i class="bi bi-percent"></i> Giảm (%)</label>
                    <input type="number" name="discount_value" id="discount_value" class="form-control"
                        value="<?= old('discount_value', $body) ?>" min="0" max="100">
                    <div class="small text-danger mt-1"><?= form_error('discount_value', $errors) ?></div>
                </div>

                <!-- Số lượng -->
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-bold"><i class="bi bi-stack"></i> Số lượng</label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        value="<?= old('quantity', $body) ?>" min="0">
                    <div class="small text-danger mt-1"><?= form_error('quantity', $errors) ?></div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Ngày bắt đầu -->
                <div class="mb-3">
                    <label for="start_date" class="form-label fw-bold"><i class="bi bi-calendar-check"></i> Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="<?= old('start_date', $body) ?>">
                    <div class="small text-danger mt-1"><?= form_error('start_date', $errors) ?></div>
                </div>

                <!-- Ngày kết thúc -->
                <div class="mb-3">
                    <label for="end_date" class="form-label fw-bold"><i class="bi bi-calendar-x"></i> Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="<?= old('end_date', $body) ?>">
                    <div class="small text-danger mt-1"><?= form_error('end_date', $errors) ?></div>
                </div>

                <!-- Trạng thái -->
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" value="1" name="isActive" id="isActive"
                        <?= (old('isActive', $body, $voucher['isActive']) == 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="isActive">
                        Kích hoạt voucher
                    </label>
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Cập nhật</button>
                <a href="?module=admin&controller=vouchers&action=List" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Hủy</a>
            </div>
        </div>
    </form>
</div>