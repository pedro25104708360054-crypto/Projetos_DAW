<?php
require_once 'config/auth_admin.php';
require_once 'config/conexao.php';
require_once 'config/admin_layout.php';
$servicos = $pdo->query("SELECT id, nome FROM servicos WHERE status='Ativo' ORDER BY nome")->fetchAll();
$funcionarios = $pdo->query("SELECT id, nome FROM funcionarios WHERE status='Ativo' ORDER BY nome")->fetchAll();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $servico_id = (int)($_POST['servico_id'] ?? 0);
    $funcionario_id = $_POST['funcionario_id'] !== '' ? (int)$_POST['funcionario_id'] : null;
    $data = $_POST['data_agendamento'] ?? '';
    $hora = $_POST['hora_agendamento'] ?? '';
    $observacao = trim($_POST['observacao'] ?? '');
    if ($nome && $servico_id && $data && $hora) {
        $pdo->prepare('INSERT INTO clientes (nome,email,telefone,observacao) VALUES (?,?,?,?)')->execute([$nome,$email,$telefone,$observacao]);
        $cliente_id = $pdo->lastInsertId();
        $pdo->prepare('INSERT INTO agendamentos (cliente_id, funcionario_id, servico_id, data_agendamento, hora_agendamento, observacao) VALUES (?,?,?,?,?,?)')->execute([$cliente_id,$funcionario_id,$servico_id,$data,$hora,$observacao]);
        $msg = 'Cliente e agendamento cadastrados com sucesso.';
    } else $msg = 'Preencha nome, serviço, data e hora.';
}
admin_header('Agendar cliente');
?>
<section class="admin-form-card"><h1>Agendar cliente</h1><?php if($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?><form method="POST" class="admin-form"><label>Nome</label><input name="nome" required><label>E-mail</label><input type="email" name="email"><label>Telefone</label><input name="telefone"><label>Serviço</label><select name="servico_id" required><option value="">Selecione</option><?php foreach($servicos as $s): ?><option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option><?php endforeach; ?></select><label>Funcionário</label><select name="funcionario_id"><option value="">Sem preferência</option><?php foreach($funcionarios as $f): ?><option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option><?php endforeach; ?></select><label>Data</label><input type="date" name="data_agendamento" required><label>Hora</label><input type="time" name="hora_agendamento" required><label>Comentário</label><textarea name="observacao"></textarea><button>Salvar</button></form></section>
<?php admin_footer(); ?>
