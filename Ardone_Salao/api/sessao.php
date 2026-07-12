<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

startSession();
connection();

jsonOut([
    'ok' => true,
    'admin' => $_SESSION['admin_nome'] ?? null,
    'cliente' => $_SESSION['cliente_nome'] ?? null,
]);
