<?php
session_start();
require_once 'config/conexao.php';
$erro = '';
$sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';
    if ($nome === '' || $email === '' || $senha === '' || $confirmar === '') $erro = 'Preencha todos os campos.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erro = 'Digite um e-mail válido.';
    elseif (strlen($senha) < 6) $erro = 'A senha precisa ter pelo menos 6 caracteres.';
    elseif ($senha !== $confirmar) $erro = 'As senhas não conferem.';
    else {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) $erro = 'Este e-mail já está cadastrado.';
        else {
            $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
            $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
            $sucesso = 'Cadastro realizado com sucesso. Agora você pode fazer login.';
        }
    }
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Cadastro</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-body"><main class="auth-container register-container"><a class="back-link" href="index.php">← Voltar para início</a><div class="auth-logo">✿</div><h1>Criar cadastro</h1>
<?php if ($erro): ?><div class="alert error"><?= htmlspecialchars($erro) ?></div><?php endif; ?><?php if ($sucesso): ?><div class="alert success"><?= htmlspecialchars($sucesso) ?></div><?php endif; ?>
<form method="POST" class="auth-form"><label>Nome</label><input type="text" name="nome" required><label>E-mail</label><input type="email" name="email" required><label>Senha</label><input type="password" name="senha" required><label>Confirmar senha</label><input type="password" name="confirmar_senha" required><button class="btn-primary">Cadastrar</button></form>
<p class="auth-extra">Já tem conta? <a href="login.php">Entrar</a></p></main></body></html>
