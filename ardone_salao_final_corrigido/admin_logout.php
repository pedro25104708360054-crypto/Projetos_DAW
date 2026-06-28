<?php
require_once __DIR__ . '/includes/helpers.php';

startSession();
unset($_SESSION['admin_id'], $_SESSION['admin_nome']);

redirect('admin_login.php');
