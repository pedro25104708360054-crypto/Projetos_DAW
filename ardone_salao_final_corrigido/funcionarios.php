<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireAdmin();

$pdo = connection();
$pageTitle = 'Funcionários';
$q = trim(getValue('q'));
$status = getValue('status');

$funcionario = ['id' => '', 'nome' => '', 'email' => '', 'telefone' => '', 'funcao' => '', 'status' => 'Ativo'];

if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM funcionarios WHERE id = ?');
    $stmt->execute([(int) $_GET['editar']]);
    $funcionario = $stmt->fetch() ?: $funcionario;
}

$where = [];
$params = [];

if ($q !== '') {
    $where[] = '(nome LIKE ? OR email LIKE ? OR telefone LIKE ? OR funcao LIKE ?)';
    $params = ["%{$q}%", "%{$q}%", "%{$q}%", "%{$q}%"];
}

if (in_array($status, ['Ativo', 'Inativo'], true)) {
    $where[] = 'status = ?';
    $params[] = $status;
}

$sql = 'SELECT * FROM funcionarios' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY nome';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$funcionarios = $stmt->fetchAll();

require_once __DIR__ . '/views/layout/admin_header.php';
require_once __DIR__ . '/views/admin/funcionarios.php';
require_once __DIR__ . '/views/layout/admin_footer.php';
