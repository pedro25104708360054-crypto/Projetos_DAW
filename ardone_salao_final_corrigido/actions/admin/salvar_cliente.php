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
$observacao = trim(postValue('observacao'));

$errors = requiredErrors([
    'nome' => $nome,
    'e-mail' => $email,
    'telefone' => $telefone,
]);

if ($email !== '' && !validEmail($email)) {
    $errors[] = 'Informe um e-mail válido.';
}

if ($errors) {
    flash('error', implode(' ', $errors));
    redirect('../../clientes.php');
}

try {
    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE clientes SET nome = ?, email = ?, telefone = ?, observacao = ? WHERE id = ?');
        $stmt->execute([$nome, $email, $telefone, $observacao, $id]);
        flash('success', 'Cliente atualizado com sucesso.');
    } else {
        $stmt = $pdo->prepare('INSERT INTO clientes (nome, email, telefone, observacao, tipo) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nome, $email, $telefone, $observacao, 'Cliente']);
        flash('success', 'Cliente cadastrado com sucesso.');
    }
} catch (PDOException $exception) {
    flash('error', 'E-mail já cadastrado.');
}

redirect('../../clientes.php');
