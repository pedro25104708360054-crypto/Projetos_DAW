<?php

function requiredErrors(array $fields): array
{
    $errors = [];

    foreach ($fields as $label => $value) {
        if (trim((string) $value) === '') {
            $errors[] = "O campo {$label} é obrigatório.";
        }
    }

    return $errors;
}

function allowedValue(string $value, array $options, string $default): string
{
    return in_array($value, $options, true) ? $value : $default;
}

function validateAppointment(
    PDO $pdo,
    int $clienteId,
    int $funcionarioId,
    int $servicoId,
    string $data,
    string $hora,
    int $ignoreId = 0
): array {
    $errors = [];

    if ($clienteId <= 0 || $funcionarioId <= 0 || $servicoId <= 0) {
        $errors[] = 'Selecione cliente, funcionário e serviço.';
    }

    if ($data === '' || $hora === '') {
        $errors[] = 'Selecione data e hora.';
    }

    if ($data !== '' && $data < date('Y-m-d')) {
        $errors[] = 'Não é permitido agendar em data passada.';
    }

    if ($data === date('Y-m-d') && $hora !== '' && $hora <= date('H:i')) {
        $errors[] = 'Selecione um horário futuro.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM agendamentos
            WHERE funcionario_id = ?
              AND data_agendamento = ?
              AND hora_agendamento = ?
              AND status <> 'Cancelado'
              AND id <> ?");
        $stmt->execute([$funcionarioId, $data, $hora, $ignoreId]);

        if ($stmt->fetch()) {
            $errors[] = 'Este horário não está disponível para o funcionário selecionado.';
        }
    }

    return $errors;
}

function availableTimes(PDO $pdo, int $funcionarioId, string $data): array
{
    $stmt = $pdo->prepare("SELECT hora_agendamento FROM agendamentos
        WHERE funcionario_id = ?
          AND data_agendamento = ?
          AND status <> 'Cancelado'");
    $stmt->execute([$funcionarioId, $data]);

    $busyTimes = array_map(
        fn ($row) => substr($row['hora_agendamento'], 0, 5),
        $stmt->fetchAll()
    );

    $times = [];

    for ($minutes = 9 * 60; $minutes < 18 * 60; $minutes += 30) {
        $hour = sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);

        if ($data === date('Y-m-d') && $hour <= date('H:i')) {
            continue;
        }

        if (!in_array($hour, $busyTimes, true)) {
            $times[] = $hour;
        }
    }

    return $times;
}
