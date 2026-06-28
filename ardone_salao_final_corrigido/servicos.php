<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireAdmin();

$pdo = connection();
$pageTitle = 'Serviços';
$q = trim(getValue('q'));
$status = getValue('status');
$servico = ['id' => '', 'nome' => '', 'preco' => '0.00', 'duracao_min' => '60', 'status' => 'Ativo'];

if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM servicos WHERE id = ?');
    $stmt->execute([(int) $_GET['editar']]);
    $servico = $stmt->fetch() ?: $servico;
}

$where = [];
$params = [];

if ($q !== '') {
    $where[] = 'nome LIKE ?';
    $params[] = "%{$q}%";
}

if (in_array($status, ['Ativo', 'Inativo'], true)) {
    $where[] = 'status = ?';
    $params[] = $status;
}

$sql = 'SELECT * FROM servicos' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY nome';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$servicos = $stmt->fetchAll();

require_once __DIR__ . '/views/layout/admin_header.php';
require_once __DIR__ . '/views/admin/servicos.php';
require_once __DIR__ . '/views/layout/admin_footer.php';
