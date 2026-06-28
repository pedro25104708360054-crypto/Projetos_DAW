<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/validation.php';

requireUser();

$pdo = connection();
$clienteId = (int) $_SESSION['cliente_id'];
$funcionarioId = (int) postValue('funcionario_id');
$servicoId = (int) postValue('servico_id');
$data = postValue('data_agendamento');
$hora = postValue('hora_agendamento');
$observacao = trim(postValue('observacao'));

$errors = validateAppointment($pdo, $clienteId, $funcionarioId, $servicoId, $data, $hora);

if ($errors) {
    flash('error', implode(' ', $errors));
    redirect('../../usuario_area.php');
}

$stmt = $pdo->prepare('INSERT INTO agendamentos (cliente_id, funcionario_id, servico_id, data_agendamento, hora_agendamento, status, observacao) VALUES (?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$clienteId, $funcionarioId, $servicoId, $data, $hora, 'Agendado', $observacao]);

flash('success', 'Horário marcado com sucesso.');
redirect('../../usuario_area.php');
