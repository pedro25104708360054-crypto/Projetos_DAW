<?php
require_once __DIR__ . '/../includes/helpers.php';

try {
    require_once __DIR__ . '/../config/database.php';
    startSession();
    $pdo = connection();
    $acao = campo('acao', $_SERVER['REQUEST_METHOD'] === 'POST' ? 'salvar' : 'listar');
    $origem = campo('origem', 'admin');

    if ($acao === 'listar') {
        if ($origem === 'cliente') {
            exigirCliente();
            $stmt = $pdo->prepare("SELECT a.*, f.nome AS funcionario, s.nome AS servico
                FROM agendamentos a
                INNER JOIN funcionarios f ON f.id = a.funcionario_id
                INNER JOIN servicos s ON s.id = a.servico_id
                WHERE a.cliente_id = ?
                ORDER BY a.id DESC");
            $stmt->execute(array($_SESSION['cliente_id']));
        } else {
            exigirAdmin();
            $stmt = $pdo->query("SELECT a.*, c.nome AS cliente, f.nome AS funcionario, s.nome AS servico
                FROM agendamentos a
                INNER JOIN clientes c ON c.id = a.cliente_id
                INNER JOIN funcionarios f ON f.id = a.funcionario_id
                INNER JOIN servicos s ON s.id = a.servico_id
                ORDER BY a.id DESC");
        }

        jsonOut(array('ok' => true, 'dados' => $stmt->fetchAll()));
    }

    if ($acao === 'excluir') {
        exigirAdmin();
        $stmt = $pdo->prepare('DELETE FROM agendamentos WHERE id = ?');
        $stmt->execute(array((int) campo('id')));
        jsonOut(array('ok' => true));
    }

    $id = (int) campo('id');

    if ($origem === 'cliente') {
        exigirCliente();
        $cliente = (int) $_SESSION['cliente_id'];
        $status = 'Agendado';
    } else {
        exigirAdmin();
        $cliente = (int) campo('cliente_id');
        $status = campo('status', 'Agendado');
    }

    $funcionario = (int) campo('funcionario_id');
    $servico = (int) campo('servico_id');
    $data = campo('data_agendamento');
    $hora = campo('hora_agendamento');
    $obs = trim(campo('observacao'));
    $formaPagamento = campo('forma_pagamento', 'Dinheiro');
    $nomeCartao = trim(campo('nome_cartao'));
    $numeroCartao = preg_replace('/\D/', '', campo('numero_cartao'));
    $validadeCartao = trim(campo('validade_cartao'));
    $cvvCartao = preg_replace('/\D/', '', campo('cvv_cartao'));

    if ($cliente <= 0 || $funcionario <= 0 || $servico <= 0 || $data === '' || $hora === '') {
        jsonOut(array('ok' => false, 'mensagem' => 'Preencha todos os campos do agendamento.'), 400);
    }

    if ($origem === 'cliente' && ($formaPagamento === 'Cartão de débito' || $formaPagamento === 'Cartão de crédito')) {
        if ($nomeCartao === '' || strlen($numeroCartao) < 12 || $validadeCartao === '' || strlen($cvvCartao) < 3) {
            jsonOut(array('ok' => false, 'mensagem' => 'Dados do cartão incompletos.'), 400);
        }
    }

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM funcionario_servicos WHERE funcionario_id = ? AND servico_id = ?');
    $stmt->execute(array($funcionario, $servico));
    if ($stmt->fetchColumn() == 0) {
        jsonOut(array('ok' => false, 'mensagem' => 'Funcionário não atende este serviço.'), 400);
    }

    $stmt = $pdo->prepare("SELECT id FROM agendamentos
        WHERE funcionario_id = ?
          AND data_agendamento = ?
          AND hora_agendamento = ?
          AND status <> 'Cancelado'
          AND id <> ?");
    $stmt->execute(array($funcionario, $data, $hora, $id));

    if ($stmt->fetch()) {
        jsonOut(array('ok' => false, 'mensagem' => 'Este funcionário já tem agendamento nesse horário.'), 400);
    }

    $stmt = $pdo->prepare("SELECT id FROM agendamentos
        WHERE cliente_id = ?
          AND data_agendamento = ?
          AND hora_agendamento = ?
          AND status <> 'Cancelado'
          AND id <> ?");
    $stmt->execute(array($cliente, $data, $hora, $id));

    if ($stmt->fetch()) {
        jsonOut(array('ok' => false, 'mensagem' => 'Cliente já tem serviço nesse mesmo horário.'), 400);
    }

    if ($id > 0 && $origem !== 'cliente') {
        $stmt = $pdo->prepare('UPDATE agendamentos SET cliente_id = ?, funcionario_id = ?, servico_id = ?, data_agendamento = ?, hora_agendamento = ?, status = ?, observacao = ? WHERE id = ?');
        $stmt->execute(array($cliente, $funcionario, $servico, $data, $hora, $status, $obs, $id));
        jsonOut(array('ok' => true));
    }

    $stmt = $pdo->prepare('INSERT INTO agendamentos (cliente_id, funcionario_id, servico_id, data_agendamento, hora_agendamento, status, observacao) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($cliente, $funcionario, $servico, $data, $hora, $status, $obs));
    $agendamentoId = $pdo->lastInsertId();

    if ($origem === 'cliente') {
        $stmt = $pdo->prepare('SELECT preco FROM servicos WHERE id = ?');
        $stmt->execute(array($servico));
        $valor = $stmt->fetchColumn();

        if ($valor === false) {
            $valor = 0;
        }

        $stmt = $pdo->prepare('INSERT INTO pagamentos (cliente_id, agendamento_id, valor, forma_pagamento, status, data_pagamento, observacao) VALUES (?, ?, ?, ?, ?, CURDATE(), ?)');
        $stmt->execute(array($cliente, $agendamentoId, $valor, $formaPagamento, 'Pago', 'Pagamento feito no agendamento'));

        if ($formaPagamento === 'Cartão de débito' || $formaPagamento === 'Cartão de crédito') {
            $finalCartao = substr($numeroCartao, -4);
            $stmt = $pdo->prepare('INSERT INTO cartoes_cliente (cliente_id, nome_cartao, final_cartao, validade, tipo_cartao) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute(array($cliente, $nomeCartao, $finalCartao, $validadeCartao, $formaPagamento));
        }
    }

    jsonOut(array('ok' => true));
} catch (Exception $e) {
    jsonOut(array('ok' => false, 'mensagem' => 'Erro no PHP: ' . $e->getMessage()), 500);
}
