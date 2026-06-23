<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
if (isset($_GET['excluir'])) { $pdo->prepare('DELETE FROM servicos WHERE id=?')->execute([(int)$_GET['excluir']]); header('Location: admin_servicos.php'); exit; }
$lista = $pdo->query('SELECT * FROM servicos ORDER BY id DESC')->fetchAll();
admin_header('Serviços');
?>
<section class="admin-panel"><div class="panel-title"><h1>Serviços</h1><a class="mini-btn" href="admin_novo_servico.php">Adicionar serviço</a></div><table><thead><tr><th>Nome</th><th>Categoria</th><th>Preço</th><th>Duração</th><th>Status</th><th>Ações</th></tr></thead><tbody><?php foreach($lista as $s): ?><tr><td><?= htmlspecialchars($s['nome']) ?></td><td><?= htmlspecialchars($s['categoria']) ?></td><td>R$ <?= number_format($s['preco'],2,',','.') ?></td><td><?= (int)$s['duracao_min'] ?> min</td><td><span class="status"><?= htmlspecialchars($s['status']) ?></span></td><td><a class="danger" onclick="return confirm('Excluir serviço?')" href="?excluir=<?= $s['id'] ?>">Excluir</a></td></tr><?php endforeach; ?></tbody></table></section>
<?php admin_footer(); ?>
