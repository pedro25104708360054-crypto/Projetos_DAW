<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
if (isset($_GET['excluir'])) {
    $stmt = $pdo->prepare('DELETE FROM agendamentos WHERE id=?');
    $stmt->execute([(int)$_GET['excluir']]);
    header('Location: admin_agendamentos.php'); exit;
}
if (isset($_GET['finalizar'])) {
    $stmt = $pdo->prepare("UPDATE agendamentos SET status='Finalizado' WHERE id=?");
    $stmt->execute([(int)$_GET['finalizar']]);
    header('Location: admin_agendamentos.php'); exit;
}
$sql = 'SELECT a.id, c.nome cliente, f.nome funcionario, s.nome servico, a.data_agendamento, a.hora_agendamento, a.status
        FROM agendamentos a
        JOIN clientes c ON c.id=a.cliente_id
        LEFT JOIN funcionarios f ON f.id=a.funcionario_id
        JOIN servicos s ON s.id=a.servico_id
        ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC';
$lista = $pdo->query($sql)->fetchAll();
admin_header('Agendamentos');
?>
<section class="admin-panel"><div class="panel-title"><h1>Lista de agendamentos</h1><a class="mini-btn" href="admin_novo_cliente.php">Adicionar</a></div><table><thead><tr><th>Cliente</th><th>Funcionário</th><th>Serviço</th><th>Data</th><th>Hora</th><th>Status</th><th>Ações</th></tr></thead><tbody>
<?php foreach($lista as $item): ?><tr><td><?= htmlspecialchars($item['cliente']) ?></td><td><?= htmlspecialchars($item['funcionario'] ?? '-') ?></td><td><?= htmlspecialchars($item['servico']) ?></td><td><?= date('d/m/Y', strtotime($item['data_agendamento'])) ?></td><td><?= substr($item['hora_agendamento'],0,5) ?></td><td><span class="status"><?= htmlspecialchars($item['status']) ?></span></td><td><a href="?finalizar=<?= $item['id'] ?>">Finalizar</a> | <a class="danger" href="?excluir=<?= $item['id'] ?>" onclick="return confirm('Excluir agendamento?')">Excluir</a></td></tr><?php endforeach; ?>
<?php if (!$lista): ?><tr><td colspan="7">Nenhum agendamento encontrado.</td></tr><?php endif; ?></tbody></table></section>
<?php admin_footer(); ?>
