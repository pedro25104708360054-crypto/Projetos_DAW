<?php
require_once __DIR__ . '/../includes/helpers.php';

try {
    require_once __DIR__ . '/../config/database.php';
    startSession();
    $pdo = connection();

    $servicoId = (int) campo('servico_id', 0);

    $clientes = $pdo->query('SELECT id, nome FROM clientes ORDER BY nome')->fetchAll();
    $servicos = $pdo->query("SELECT id, nome, preco FROM servicos WHERE status = 'Ativo' ORDER BY nome")->fetchAll();

    if ($servicoId > 0) {
        $stmt = $pdo->prepare("SELECT f.id, f.nome
            FROM funcionarios f
            INNER JOIN funcionario_servicos fs ON fs.funcionario_id = f.id
            WHERE fs.servico_id = ? AND f.status = 'Ativo'
            ORDER BY f.nome");
        $stmt->execute(array($servicoId));
        $funcionarios = $stmt->fetchAll();
    } else {
        $funcionarios = $pdo->query("SELECT id, nome FROM funcionarios WHERE status = 'Ativo' ORDER BY nome")->fetchAll();
    }

    $agendamentos = $pdo->query("SELECT a.id, c.nome AS cliente, s.nome AS servico
        FROM agendamentos a
        INNER JOIN clientes c ON c.id = a.cliente_id
        INNER JOIN servicos s ON s.id = a.servico_id
        ORDER BY a.id DESC")->fetchAll();

    jsonOut(array(
        'ok' => true,
        'clientes' => $clientes,
        'funcionarios' => $funcionarios,
        'servicos' => $servicos,
        'agendamentos' => $agendamentos
    ));
} catch (Exception $e) {
    jsonOut(array('ok' => false, 'mensagem' => 'Erro no PHP: ' . $e->getMessage()), 500);
}
