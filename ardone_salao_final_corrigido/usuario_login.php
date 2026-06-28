<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

startSession();

$pdo = connection();
$error = '';

if (userLogged()) {
    redirect('usuario_area.php');
}

if (isPost()) {
    $email = trim(postValue('email'));
    $senha = (string) postValue('senha');

    if (!validEmail($email) || $senha === '') {
        $error = 'Informe e-mail e senha válidos.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = ? AND tipo = 'Usuario' LIMIT 1");
        $stmt->execute([$email]);
        $cliente = $stmt->fetch();

        if ($cliente && password_verify($senha, $cliente['senha'] ?? '')) {
            loginUser($cliente);
            redirect('usuario_area.php');
        }

        $error = 'E-mail ou senha inválidos.';
    }
}

require_once __DIR__ . '/views/auth/usuario_login.php';
