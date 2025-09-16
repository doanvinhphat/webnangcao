<?php
$menuItems = [
    ["label" => "Dashboard", "icon" => "fa-solid fa-gauge", "controller" => null, "action" => "dashboard"],
    ["label" => "Người dùng", "icon" => "fa-solid fa-users", "controller" => "users", "action" => "list"],
    ["label" => "Bài viết", "icon" => "fa-solid fa-file-lines", "controller" => "posts", "action" => "list"],
];
?>
<div class="d-flex flex-column p-3 text-white sidebar">
    <!-- Logo + Admin -->
    <div class="d-flex align-items-center mb-4">
        <img src="<?= BASE_URL ?>/logo.png" alt="Logo" class="me-2" style="width:40px;">
        <div>
            <div class="fw-bold">ADMIN</div>
            <small><?= htmlspecialchars($fullname ?? '') ?></small>
        </div>
    </div>
    <hr class="border-secondary">

    <!-- Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <?php foreach ($menuItems as $item): ?>
            <?php
            $url = BASE_URL . "/index.php?module=admin";
            if ($item['controller']) {
                $url .= "&controller=" . $item['controller'];
            }
            $url .= "&action=" . $item['action'];

            // xác định active
            $isActive = ($controller === $item['controller'] && $action === $item['action'])
                || (!$controller && $item['controller'] === null && $action === $item['action']);
            ?>
            <li>
                <a href="<?= $url ?>" class="nav-link text-white <?= $isActive ? 'active' : '' ?>">
                    <i class="<?= $item['icon'] ?>"></i>
                    <?= $item['label'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>