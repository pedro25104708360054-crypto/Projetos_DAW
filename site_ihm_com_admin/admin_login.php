<?php
session_start();
require_once 'config/conexao.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($senha, $admin['senha'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nome'] = $admin['nome'];
        header('Location: admin_dashboard.php'); exit;
    }
    $erro = 'Login administrativo inválido.';
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login Admin</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="admin-login-body"><main class="admin-login-card"><h1>Bem-vindo</h1><?php if ($erro): ?><div class="alert error"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="POST"><label>E-mail</label><input type="email" name="email" required><label>Senha</label><input type="password" name="senha" required><button>Entrar</button></form><p class="admin-hint">Padrão: admin@admin.com / password</p></main></body></html>
