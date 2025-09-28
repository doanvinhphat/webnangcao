<?php

$site_settings = getRows('SELECT * FROM site_settings');

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<section class="px-2 mt-2">
    <?php getMsg($msg, $msgType); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Cài đặt thông tin</h1>
    </div>

    <hr class="border border-3 border-dark">

    <div class="my-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Hotline 1</th>
                    <th>Hotline 2</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Giờ làm việc</th>
                    <th>Facebook</th>
                    <th>Instagram</th>
                    <th>Youtube</th>
                    <th>Twitter</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($site_settings)) : ?>
                    <?php foreach ($site_settings as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['hotline1']) ?></td>
                            <td><?= htmlspecialchars($item['hotline2']) ?></td>
                            <td class="text-ellipsis" title="<?= htmlspecialchars($item['email']) ?>">
                                <?= htmlspecialchars($item['email']) ?>
                            </td>
                            <td class="text-ellipsis" title="<?= htmlspecialchars($item['address']) ?>">
                                <?= htmlspecialchars($item['address']) ?>
                            </td>
                            <td><?= htmlspecialchars($item['working_hours']) ?></td>
                            <td>
                                <?php if (!empty($item['facebook_link'])): ?>
                                    <a href="<?= htmlspecialchars($item['facebook_link']) ?>" target="_blank">Facebook</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($item['instagram_link'])): ?>
                                    <a href="<?= htmlspecialchars($item['instagram_link']) ?>" target="_blank">Instagram</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($item['youtube_link'])): ?>
                                    <a href="<?= htmlspecialchars($item['youtube_link']) ?>" target="_blank">Youtube</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($item['twitter_link'])): ?>
                                    <a href="<?= htmlspecialchars($item['twitter_link']) ?>" target="_blank">Twitter</a>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['updated_at']) ?></td>
                            <td>
                                <a href="<?= buildUrl('site_settings', 'Edit', ['id' => $item['id']]) ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</section>