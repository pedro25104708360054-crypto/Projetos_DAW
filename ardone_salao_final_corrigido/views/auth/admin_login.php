<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
    <main class="login-card">
        <div class="login-logo">✿</div>
        <h1>Área administrativa</h1>

        <?php if ($error): ?>
            <div class="alert error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="form-stack">
            <label>E-mail</label>
            <input type="email" name="email" value="admin@ardone.com.br" required>

            <label>Senha</label>
            <input type="password" name="senha" placeholder="123456" required>

            <button class="btn primary">Entrar</button>
        </form>

        <p class="hint">Admin: admin@ardone.com.br / 123456</p>
        <a href="index.php" class="back-link">Voltar ao site</a>
    </main>
</body>
</html>
