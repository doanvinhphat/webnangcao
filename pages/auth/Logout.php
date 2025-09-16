<?php
if (!defined('_INCODE')) die('Truy cập bị từ chối!');

//xóa session
removeSession();

redirect('?module=auth&action=login');
exit;