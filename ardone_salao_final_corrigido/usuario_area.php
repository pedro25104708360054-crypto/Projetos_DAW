<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validation.php';

requireUser();

$pdo = connection();
$pageTitle = 'Área do cliente';
$clienteId = (int) $_SESSION['cliente_id'];

$funcionarios = $pdo->query("SELECT id, nome FROM funcionarios WHERE status = 'Ativo' ORDER BY nome")->fetchAll();
$servicos = $pdo->query("SELECT id, nome, preco FROM servicos WHERE status = 'Ativo' ORDER BY nome")->fetchAll();

$stmt = $pdo->prepare("SELECT a.*, f.nome AS funcionario, s.nome AS servico
    FROM agendamentos a
    INNER JOIN funcionarios f ON f.id = a.funcionario_id
    INNER JOIN servicos s ON s.id = a.servico_id
    WHERE a.cliente_id = ?
    ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC");
$stmt->execute([$clienteId]);
$meusAgendamentos = $stmt->fetchAll();

require_once __DIR__ . '/views/layout/user_header.php';
require_once __DIR__ . '/views/cliente/area.php';
require_once __DIR__ . '/views/layout/footer.php';
