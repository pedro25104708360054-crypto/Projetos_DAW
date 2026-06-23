<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
$totais = [
    'clientes' => $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn(),
    'agendamentos' => $pdo->query('SELECT COUNT(*) FROM agendamentos')->fetchColumn(),
    'funcionarios' => $pdo->query('SELECT COUNT(*) FROM funcionarios')->fetchColumn(),
    'servicos' => $pdo->query('SELECT COUNT(*) FROM servicos')->fetchColumn(),
];
$sql = 'SELECT a.id, c.nome cliente, s.nome servico, a.data_agendamento, a.hora_agendamento, a.status
        FROM agendamentos a
        JOIN clientes c ON c.id=a.cliente_id
        JOIN servicos s ON s.id=a.servico_id
        ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC LIMIT 8';
$agendamentos = $pdo->query($sql)->fetchAll();
admin_header('Visão geral');
?>
<section class="cards-row"><div><strong><?= $totais['clientes'] ?></strong><span>Clientes</span></div><div><strong><?= $totais['agendamentos'] ?></strong><span>Agendamentos</span></div><div><strong><?= $totais['funcionarios'] ?></strong><span>Funcionários</span></div><div><strong><?= $totais['servicos'] ?></strong><span>Serviços</span></div></section>
<section class="admin-panel"><div class="panel-title"><h1>Agendamentos recentes</h1><a class="mini-btn" href="admin_novo_cliente.php">Novo agendamento</a></div><table><thead><tr><th>Cliente</th><th>Serviço</th><th>Data</th><th>Hora</th><th>Status</th></tr></thead><tbody>
<?php foreach($agendamentos as $a): ?><tr><td><?= htmlspecialchars($a['cliente']) ?></td><td><?= htmlspecialchars($a['servico']) ?></td><td><?= date('d/m/Y', strtotime($a['data_agendamento'])) ?></td><td><?= substr($a['hora_agendamento'],0,5) ?></td><td><span class="status"><?= htmlspecialchars($a['status']) ?></span></td></tr><?php endforeach; ?>
<?php if (!$agendamentos): ?><tr><td colspan="5">Nenhum agendamento cadastrado.</td></tr><?php endif; ?></tbody></table></section>
<?php admin_footer(); ?>
