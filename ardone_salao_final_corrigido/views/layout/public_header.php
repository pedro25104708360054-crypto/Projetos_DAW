<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../includes/auth.php';

startSession();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <a href="index.php" class="logo">✿ <?= APP_NAME ?></a>

        <nav>
            <a href="index.php#servicos">Serviços</a>
            <a href="index.php#equipe">Equipe</a>
            <a href="usuario_login.php">Área do cliente</a>
            <a href="admin_login.php">Admin</a>
        </nav>
    </header>
