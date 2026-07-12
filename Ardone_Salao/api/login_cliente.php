<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

startSession();
$pdo = connection();
$acao = campo('acao', 'login');

if ($acao === 'cadastrar') {
    $nome = trim(campo('nome'));
    $email = trim(campo('email'));
    $telefone = trim(campo('telefone'));
    $senha = (string) campo('senha');

    if ($nome === '' || $email === '' || $telefone === '' || strlen($senha) < 6) {
        jsonOut(['ok' => false, 'mensagem' => 'Preencha todos os campos.'], 400);
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO clientes (nome, email, telefone, senha, tipo) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nome, $email, $telefone, password_hash($senha, PASSWORD_DEFAULT), 'Usuario']);
        jsonOut(['ok' => true]);
    } catch (PDOException $e) {
        jsonOut(['ok' => false, 'mensagem' => 'E-mail ja cadastrado.'], 400);
    }
}

$email = trim(campo('email'));
$senha = (string) campo('senha');
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = ? AND tipo = 'Usuario' LIMIT 1");
$stmt->execute([$email]);
$cliente = $stmt->fetch();

if ($cliente && password_verify($senha, $cliente['senha'] ?? '')) {
    $_SESSION['cliente_id'] = $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome'];
    unset($_SESSION['admin_id'], $_SESSION['admin_nome']);
    jsonOut(['ok' => true]);
}

jsonOut(['ok' => false, 'mensagem' => 'Login invalido.'], 401);
