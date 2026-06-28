<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/validation.php';

requireAdmin();

$pdo = connection();
$id = (int) postValue('id');
$nome = trim(postValue('nome'));
$email = trim(postValue('email'));
$telefone = trim(postValue('telefone'));
$funcao = trim(postValue('funcao'));
$status = allowedValue(postValue('status'), ['Ativo', 'Inativo'], 'Ativo');

$errors = requiredErrors(['nome' => $nome, 'função' => $funcao]);

if ($email !== '' && !validEmail($email)) {
    $errors[] = 'Informe um e-mail válido.';
}

if ($errors) {
    flash('error', implode(' ', $errors));
    redirect('../../funcionarios.php');
}

if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE funcionarios SET nome = ?, email = ?, telefone = ?, funcao = ?, status = ? WHERE id = ?');
    $stmt->execute([$nome, $email, $telefone, $funcao, $status, $id]);
    flash('success', 'Funcionário atualizado com sucesso.');
} else {
    $stmt = $pdo->prepare('INSERT INTO funcionarios (nome, email, telefone, funcao, status) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nome, $email, $telefone, $funcao, $status]);
    flash('success', 'Funcionário cadastrado com sucesso.');
}

redirect('../../funcionarios.php');
