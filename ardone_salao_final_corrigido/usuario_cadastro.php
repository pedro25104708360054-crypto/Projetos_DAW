<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validation.php';

startSession();

$pdo = connection();
$errors = [];

if (userLogged()) {
    redirect('usuario_area.php');
}

if (isPost()) {
    $nome = trim(postValue('nome'));
    $email = trim(postValue('email'));
    $telefone = trim(postValue('telefone'));
    $senha = (string) postValue('senha');
    $confirmar = (string) postValue('confirmar');

    $errors = array_merge($errors, requiredErrors([
        'nome' => $nome,
        'e-mail' => $email,
        'telefone' => $telefone,
        'senha' => $senha,
    ]));

    if ($email !== '' && !validEmail($email)) {
        $errors[] = 'Informe um e-mail válido.';
    }

    if (strlen($senha) < 6) {
        $errors[] = 'A senha deve ter pelo menos 6 caracteres.';
    }

    if ($senha !== $confirmar) {
        $errors[] = 'As senhas não conferem.';
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO clientes (nome, email, telefone, senha, tipo) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$nome, $email, $telefone, password_hash($senha, PASSWORD_DEFAULT), 'Usuario']);

            flash('success', 'Conta criada com sucesso. Faça login para agendar.');
            redirect('usuario_login.php');
        } catch (PDOException $exception) {
            $errors[] = 'Este e-mail já está cadastrado.';
        }
    }
}

require_once __DIR__ . '/views/auth/usuario_cadastro.php';
