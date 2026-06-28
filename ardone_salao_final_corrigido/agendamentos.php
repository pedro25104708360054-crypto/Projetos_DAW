<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireAdmin();

$pdo = connection();
$pageTitle = 'Agendamentos';
$q = trim(getValue('q'));
$data = getValue('data');
$status = getValue('status');

$agendamento = [
    'id' => '',
    'cliente_id' => '',
    'funcionario_id' => '',
    'servico_id' => '',
    'data_agendamento' => date('Y-m-d'),
    'hora_agendamento' => '',
    'status' => 'Agendado',
    'observacao' => '',
];

if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM agendamentos WHERE id = ?');
    $stmt->execute([(int) $_GET['editar']]);
    $agendamento = $stmt->fetch() ?: $agendamento;
}

$clientes = $pdo->query('SELECT id, nome FROM clientes ORDER BY nome')->fetchAll();
$funcionarios = $pdo->query("SELECT id, nome FROM funcionarios WHERE status = 'Ativo' ORDER BY nome")->fetchAll();
$servicos = $pdo->query("SELECT id, nome FROM servicos WHERE status = 'Ativo' ORDER BY nome")->fetchAll();

$where = [];
$params = [];

if ($q !== '') {
    $where[] = '(c.nome LIKE ? OR f.nome LIKE ? OR s.nome LIKE ?)';
    $params = ["%{$q}%", "%{$q}%", "%{$q}%"];
}

if ($data !== '') {
    $where[] = 'a.data_agendamento = ?';
    $params[] = $data;
}

if (in_array($status, ['Agendado', 'Confirmado', 'Finalizado', 'Cancelado'], true)) {
    $where[] = 'a.status = ?';
    $params[] = $status;
}

$sql = "SELECT a.*, c.nome AS cliente, f.nome AS funcionario, s.nome AS servico
    FROM agendamentos a
    INNER JOIN clientes c ON c.id = a.cliente_id
    INNER JOIN funcionarios f ON f.id = a.funcionario_id
    INNER JOIN servicos s ON s.id = a.servico_id";
$sql .= $where ? ' WHERE ' . implode(' AND ', $where) : '';
$sql .= ' ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$agendamentos = $stmt->fetchAll();

require_once __DIR__ . '/views/layout/admin_header.php';
require_once __DIR__ . '/views/admin/agendamentos.php';
require_once __DIR__ . '/views/layout/admin_footer.php';
