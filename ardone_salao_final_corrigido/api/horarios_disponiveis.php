<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/validation.php';

header('Content-Type: application/json; charset=utf-8');

$pdo = connection();
$funcionarioId = (int) ($_GET['funcionario_id'] ?? 0);
$data = $_GET['data'] ?? '';

if ($funcionarioId <= 0 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data) || $data < date('Y-m-d')) {
    echo json_encode([]);
    exit;
}

$horarios = availableTimes($pdo, $funcionarioId, $data);

$resultado = array_map(
    fn ($hora) => ['value' => $hora, 'label' => $hora],
    $horarios
);

echo json_encode($resultado);
