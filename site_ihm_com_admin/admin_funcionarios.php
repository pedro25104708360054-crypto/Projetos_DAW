<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
if (isset($_GET['excluir'])) { $pdo->prepare('DELETE FROM funcionarios WHERE id=?')->execute([(int)$_GET['excluir']]); header('Location: admin_funcionarios.php'); exit; }
$lista = $pdo->query('SELECT * FROM funcionarios ORDER BY id DESC')->fetchAll();
admin_header('Controle de funcionários');
?>
<section class="admin-panel"><div class="panel-title"><h1>Controle de funcionários</h1><a class="mini-btn" href="admin_novo_funcionario.php">Adicionar funcionário</a></div><table><thead><tr><th>Nome</th><th>E-mail</th><th>Telefone</th><th>Função</th><th>Status</th><th>Ações</th></tr></thead><tbody><?php foreach($lista as $f): ?><tr><td><?= htmlspecialchars($f['nome']) ?></td><td><?= htmlspecialchars($f['email']) ?></td><td><?= htmlspecialchars($f['telefone']) ?></td><td><?= htmlspecialchars($f['funcao']) ?></td><td><span class="status"><?= htmlspecialchars($f['status']) ?></span></td><td><a class="danger" onclick="return confirm('Excluir funcionário?')" href="?excluir=<?= $f['id'] ?>">Excluir</a></td></tr><?php endforeach; ?></tbody></table></section>
<?php admin_footer(); ?>
