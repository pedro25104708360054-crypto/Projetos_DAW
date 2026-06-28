<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/validation.php';

requireAdmin();

$pdo = connection();
$id = (int) postValue('id');
$nome = trim(postValue('nome'));
$preco = str_replace(',', '.', trim(postValue('preco')));
$duracao = (int) postValue('duracao_min');
$status = allowedValue(postValue('status'), ['Ativo', 'Inativo'], 'Ativo');

$errors = requiredErrors(['nome' => $nome, 'preço' => $preco]);

if (!is_numeric($preco) || $preco < 0) {
    $errors[] = 'Informe um preço válido.';
}

if ($duracao < 15) {
    $errors[] = 'Duração mínima de 15 minutos.';
}

if ($errors) {
    flash('error', implode(' ', $errors));
    redirect('../../servicos.php');
}

if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE servicos SET nome = ?, preco = ?, duracao_min = ?, status = ? WHERE id = ?');
    $stmt->execute([$nome, $preco, $duracao, $status, $id]);
    flash('success', 'Serviço atualizado com sucesso.');
} else {
    $stmt = $pdo->prepare('INSERT INTO servicos (nome, preco, duracao_min, status) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nome, $preco, $duracao, $status]);
    flash('success', 'Serviço cadastrado com sucesso.');
}

redirect('../../servicos.php');
