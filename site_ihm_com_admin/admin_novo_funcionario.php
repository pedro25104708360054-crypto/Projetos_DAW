<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $pdo->prepare('INSERT INTO funcionarios (nome,email,telefone,funcao,status) VALUES (?,?,?,?,?)')->execute([trim($_POST['nome']),trim($_POST['email']),trim($_POST['telefone']),trim($_POST['funcao']),$_POST['status']]);
    $msg='Funcionário cadastrado com sucesso.';
}
admin_header('Adicionar novo funcionário');
?>
<section class="admin-form-card"><h1>Adicionar novo funcionário</h1><?php if($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="POST" class="admin-form"><label>Nome</label><input name="nome" required><label>E-mail</label><input type="email" name="email"><label>Telefone</label><input name="telefone"><label>Função</label><input name="funcao" required><label>Status</label><select name="status"><option>Ativo</option><option>Inativo</option></select><button>Salvar</button></form></section>
<?php admin_footer(); ?>
