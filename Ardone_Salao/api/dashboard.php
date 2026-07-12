<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

exigirAdmin();
$pdo = connection();

$totais = [
    'clientes' => (int) $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn(),
    'funcionarios' => (int) $pdo->query('SELECT COUNT(*) FROM funcionarios')->fetchColumn(),
    'servicos' => (int) $pdo->query('SELECT COUNT(*) FROM servicos')->fetchColumn(),
    'agendamentos' => (int) $pdo->query('SELECT COUNT(*) FROM agendamentos')->fetchColumn(),
    'pagamentos' => (int) $pdo->query('SELECT COUNT(*) FROM pagamentos')->fetchColumn(),
];

$stmt = $pdo->query("SELECT a.*, c.nome AS cliente, f.nome AS funcionario, s.nome AS servico
    FROM agendamentos a
    INNER JOIN clientes c ON c.id = a.cliente_id
    INNER JOIN funcionarios f ON f.id = a.funcionario_id
    INNER JOIN servicos s ON s.id = a.servico_id
    ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC
    LIMIT 6");

jsonOut(['ok' => true, 'totais' => $totais, 'agendamentos' => $stmt->fetchAll()]);
