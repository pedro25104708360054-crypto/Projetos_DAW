<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

startSession();
$pdo = connection();
$email = trim(campo('email'));
$senha = (string) campo('senha');

$stmt = $pdo->prepare('SELECT * FROM administradores WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$admin = $stmt->fetch();

if ($admin && password_verify($senha, $admin['senha'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_nome'] = $admin['nome'];
    unset($_SESSION['cliente_id'], $_SESSION['cliente_nome']);
    jsonOut(['ok' => true]);
}

jsonOut(['ok' => false, 'mensagem' => 'Login invalido.'], 401);
