<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

startSession();

$pdo = connection();
$error = '';

if (adminLogged()) {
    redirect('dashboard.php');
}

if (isPost()) {
    $email = trim(postValue('email'));
    $senha = (string) postValue('senha');

    if (!validEmail($email) || $senha === '') {
        $error = 'Informe e-mail e senha válidos.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM administradores WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($senha, $admin['senha'])) {
            loginAdmin($admin);
            redirect('dashboard.php');
        }

        $error = 'E-mail ou senha inválidos.';
    }
}

require_once __DIR__ . '/views/auth/admin_login.php';
