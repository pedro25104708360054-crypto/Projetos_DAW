<?php
session_start();
require_once 'config/conexao.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: index.php'); exit;
    }
    $erro = 'E-mail ou senha inválidos.';
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-body"><main class="auth-container"><a class="back-link" href="index.php">← Voltar</a><div class="auth-logo">✿</div><h1>Login</h1>
<?php if ($erro): ?><div class="alert error"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="POST" class="auth-form"><label>E-mail</label><input type="email" name="email" required><label>Senha</label><input type="password" name="senha" required><button class="btn-primary">Acessar</button></form>
<p class="auth-extra">Não tem conta? <a href="cadastro.php">Cadastre-se</a></p></main></body></html>
