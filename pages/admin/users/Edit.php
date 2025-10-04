<?php

// Lấy id
$id = $_GET['id'] ?? null;
if (!$id) {
    setFlashData('msg', 'ID không hợp lệ');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=users&action=List');
}

// Lấy dữ liệu người dùng
$userDetail = first("SELECT * FROM users WHERE id = :id", ['id' => $id]);
if (!$userDetail) {
    setFlashData('msg', 'Người dùng không tồn tại');
    setFlashData('msg_type', 'danger');
    redirect('?module=admin&controller=users&action=List');
}

if (isPost()) {
    $body = getBody();

    if (isset($body['isActive'])) {
        $isActive = $body['isActive'] == 1 ? 1 : 0;

        $updateStatus = update('users', [
            'isActive' => $isActive,
            'id' => $id
        ], 'id=:id');

        if ($updateStatus) {
            setFlashData('msg', 'Cập nhật trạng thái thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Cập nhật thất bại, vui lòng thử lại');
            setFlashData('msg_type', 'danger');
        }
    }
    redirect('?module=admin&controller=users&action=List');
}


?>

<section class="px-2 mt-2">
    <h2>Chi tiết người dùng</h2>
    <hr class="border border-3 border-dark">

    <form method="post" onsubmit="return confirm('Bạn có chắc muốn thay đổi trạng thái tài khoản này không?');">
        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($userDetail['fullname']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($userDetail['email']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($userDetail['phone']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($userDetail['role']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="isActive" class="form-select" <?= ($currentUser['role'] !== 'admin') ? 'disabled' : '' ?>>
                <option value="1" <?= $userDetail['isActive'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= $userDetail['isActive'] == 0 ? 'selected' : '' ?>>Khóa</option>
            </select>
        </div>

        <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
            <button type="submit" class="btn btn-warning">Cập nhật trạng thái</button>
        <?php endif; ?>

        <a href="<?= buildUrl('users', 'List') ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</section>