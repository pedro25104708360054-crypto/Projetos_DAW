<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $preco = str_replace(',', '.', $_POST['preco'] ?? '0');
    $pdo->prepare('INSERT INTO servicos (nome,categoria,preco,duracao_min,status) VALUES (?,?,?,?,?)')->execute([trim($_POST['nome']),trim($_POST['categoria']),$preco,(int)$_POST['duracao_min'],$_POST['status']]);
    $msg='Serviço cadastrado com sucesso.';
}
admin_header('Adicionar novo serviço');
?>
<section class="admin-form-card"><h1>Adicionar novo serviço</h1><?php if($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="POST" class="admin-form"><label>Nome</label><input name="nome" required><label>Categoria</label><input name="categoria"><label>Preço</label><input name="preco" placeholder="Ex: 65.00"><label>Duração em minutos</label><input type="number" name="duracao_min" value="60"><label>Status</label><select name="status"><option>Ativo</option><option>Inativo</option></select><button>Salvar</button></form></section>
<?php admin_footer(); ?>
