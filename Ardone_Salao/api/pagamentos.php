<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

startSession();
$pdo = connection();
$acao = campo('acao', $_SERVER['REQUEST_METHOD'] === 'POST' ? 'salvar' : 'listar');
$origem = campo('origem', 'admin');

if ($acao === 'listar') {
    if ($origem === 'cliente') {
        exigirCliente();
        $stmt = $pdo->prepare("SELECT p.*, s.nome AS servico
            FROM pagamentos p
            LEFT JOIN agendamentos a ON a.id = p.agendamento_id
            LEFT JOIN servicos s ON s.id = a.servico_id
            WHERE p.cliente_id = ?
            ORDER BY p.id DESC");
        $stmt->execute([$_SESSION['cliente_id']]);
    } else {
        exigirAdmin();
        $stmt = $pdo->query("SELECT p.*, c.nome AS cliente
            FROM pagamentos p
            INNER JOIN clientes c ON c.id = p.cliente_id
            ORDER BY p.id DESC");
    }

    jsonOut(['ok' => true, 'dados' => $stmt->fetchAll()]);
}

exigirAdmin();

if ($acao === 'excluir') {
    $stmt = $pdo->prepare('DELETE FROM pagamentos WHERE id = ?');
    $stmt->execute([(int) campo('id')]);
    jsonOut(['ok' => true]);
}

$id = (int) campo('id');
$cliente = (int) campo('cliente_id');
$agendamento = campo('agendamento_id') ? (int) campo('agendamento_id') : null;
$valor = str_replace(',', '.', campo('valor'));
$forma = campo('forma_pagamento');
$status = campo('status');
$data = campo('data_pagamento');
$obs = trim(campo('observacao'));

if ($cliente <= 0 || !is_numeric($valor) || $valor <= 0 || $forma === '' || $status === '' || $data === '') {
    jsonOut(['ok' => false, 'mensagem' => 'Preencha os dados do pagamento corretamente.'], 400);
}

if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE pagamentos SET cliente_id = ?, agendamento_id = ?, valor = ?, forma_pagamento = ?, status = ?, data_pagamento = ?, observacao = ? WHERE id = ?');
    $stmt->execute([$cliente, $agendamento, $valor, $forma, $status, $data, $obs, $id]);
} else {
    $stmt = $pdo->prepare('INSERT INTO pagamentos (cliente_id, agendamento_id, valor, forma_pagamento, status, data_pagamento, observacao) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$cliente, $agendamento, $valor, $forma, $status, $data, $obs]);
}

jsonOut(['ok' => true]);
