<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../includes/auth.php';

requireAdmin();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Painel') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="admin-body">
    <aside class="sidebar">
        <h1><?= APP_NAME ?></h1>
        <a href="dashboard.php">Início</a>
        <a href="clientes.php">Clientes</a>
        <a href="funcionarios.php">Funcionários</a>
        <a href="servicos.php">Serviços</a>
        <a href="agendamentos.php">Agendamentos</a>
        <a href="index.php">Ver site</a>
        <a href="admin_logout.php">Sair</a>
    </aside>

    <main class="admin-main">
        <header class="admin-top">
            <span><?= e($pageTitle ?? 'Painel') ?></span>
            <strong><?= e($_SESSION['admin_nome'] ?? 'Admin') ?></strong>
        </header>

        <?php if ($message = flash('success')): ?>
            <div class="alert success"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($message = flash('error')): ?>
            <div class="alert error"><?= e($message) ?></div>
        <?php endif; ?>
