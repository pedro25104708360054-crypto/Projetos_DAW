<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
    <main class="login-card">
        <div class="login-logo">✿</div>
        <h1>Criar conta</h1>

        <?php foreach ($errors as $error): ?>
            <div class="alert error"><?= e($error) ?></div>
        <?php endforeach; ?>

        <form method="POST" class="form-stack">
            <label>Nome</label>
            <input type="text" name="nome" required>

            <label>E-mail</label>
            <input type="email" name="email" required>

            <label>Telefone</label>
            <input type="text" name="telefone" required>

            <label>Senha</label>
            <input type="password" name="senha" minlength="6" required>

            <label>Confirmar senha</label>
            <input type="password" name="confirmar" minlength="6" required>

            <button class="btn primary">Cadastrar</button>
        </form>

        <p class="hint"><a href="usuario_login.php">Já tenho conta</a></p>
    </main>
</body>
</html>
