<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../includes/auth.php';

requireUser();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Área do cliente') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="client-body">
    <header class="client-header">
        <a href="usuario_area.php" class="logo">✿ <?= APP_NAME ?></a>

        <nav>
            <a href="usuario_area.php">Minha área</a>
            <a href="usuario_logout.php">Sair</a>
        </nav>
    </header>

    <main class="client-main">
        <?php if ($message = flash('success')): ?>
            <div class="alert success"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($message = flash('error')): ?>
            <div class="alert error"><?= e($message) ?></div>
        <?php endif; ?>
