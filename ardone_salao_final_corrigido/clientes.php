<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireAdmin();

$pdo = connection();
$pageTitle = 'Clientes';
$q = trim(getValue('q'));

$cliente = [
    'id' => '',
    'nome' => '',
    'email' => '',
    'telefone' => '',
    'observacao' => '',
];

if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM clientes WHERE id = ?');
    $stmt->execute([(int) $_GET['editar']]);
    $cliente = $stmt->fetch() ?: $cliente;
}

$sql = 'SELECT * FROM clientes';
$params = [];

if ($q !== '') {
    $sql .= ' WHERE nome LIKE ? OR email LIKE ? OR telefone LIKE ?';
    $params = ["%{$q}%", "%{$q}%", "%{$q}%"];
}

$sql .= ' ORDER BY nome';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clientes = $stmt->fetchAll();

require_once __DIR__ . '/views/layout/admin_header.php';
require_once __DIR__ . '/views/admin/clientes.php';
require_once __DIR__ . '/views/layout/admin_footer.php';
