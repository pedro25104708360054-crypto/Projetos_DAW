<?php
require_once __DIR__ . '/includes/helpers.php';

startSession();
unset($_SESSION['cliente_id'], $_SESSION['cliente_nome']);

redirect('usuario_login.php');
