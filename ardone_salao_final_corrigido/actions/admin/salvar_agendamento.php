<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/validation.php';

requireAdmin();

$pdo = connection();
$id = (int) postValue('id');
$clienteId = (int) postValue('cliente_id');
$funcionarioId = (int) postValue('funcionario_id');
$servicoId = (int) postValue('servico_id');
$data = postValue('data_agendamento');
$hora = postValue('hora_agendamento');
$status = allowedValue(postValue('status'), ['Agendado', 'Confirmado', 'Finalizado', 'Cancelado'], 'Agendado');
$observacao = trim(postValue('observacao'));

$errors = validateAppointment($pdo, $clienteId, $funcionarioId, $servicoId, $data, $hora, $id);

if ($errors) {
    flash('error', implode(' ', $errors));
    redirect('../../agendamentos.php');
}

if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE agendamentos SET cliente_id = ?, funcionario_id = ?, servico_id = ?, data_agendamento = ?, hora_agendamento = ?, status = ?, observacao = ? WHERE id = ?');
    $stmt->execute([$clienteId, $funcionarioId, $servicoId, $data, $hora, $status, $observacao, $id]);
    flash('success', 'Agendamento atualizado com sucesso.');
} else {
    $stmt = $pdo->prepare('INSERT INTO agendamentos (cliente_id, funcionario_id, servico_id, data_agendamento, hora_agendamento, status, observacao) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$clienteId, $funcionarioId, $servicoId, $data, $hora, $status, $observacao]);
    flash('success', 'Agendamento cadastrado com sucesso.');
}

redirect('../../agendamentos.php');
