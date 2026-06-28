<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireAdmin();

$pdo = connection();
$pageTitle = 'Painel inicial';

$totais = [
    'Clientes' => $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn(),
    'Funcionários' => $pdo->query('SELECT COUNT(*) FROM funcionarios')->fetchColumn(),
    'Serviços' => $pdo->query('SELECT COUNT(*) FROM servicos')->fetchColumn(),
    'Agendamentos' => $pdo->query('SELECT COUNT(*) FROM agendamentos')->fetchColumn(),
];

$stmt = $pdo->query("SELECT a.*, c.nome AS cliente, f.nome AS funcionario, s.nome AS servico
    FROM agendamentos a
    INNER JOIN clientes c ON c.id = a.cliente_id
    INNER JOIN funcionarios f ON f.id = a.funcionario_id
    INNER JOIN servicos s ON s.id = a.servico_id
    ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC
    LIMIT 8");
$agendamentos = $stmt->fetchAll();

require_once __DIR__ . '/views/layout/admin_header.php';
require_once __DIR__ . '/views/admin/dashboard.php';
require_once __DIR__ . '/views/layout/admin_footer.php';
