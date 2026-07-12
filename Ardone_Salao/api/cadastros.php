<?php
require_once __DIR__ . '/../includes/helpers.php';

try {
    require_once __DIR__ . '/../config/database.php';
    exigirAdmin();
    $pdo = connection();

    $tabela = campo('tabela');
    $acao = campo('acao', $_SERVER['REQUEST_METHOD'] === 'POST' ? 'salvar' : 'listar');
    $permitidas = array('clientes', 'funcionarios', 'servicos');

    if (!in_array($tabela, $permitidas)) {
        jsonOut(array('ok' => false, 'mensagem' => 'Cadastro inválido.'), 400);
    }

    if ($acao === 'listar') {
        if ($tabela === 'clientes') {
            $stmt = $pdo->query('SELECT id, nome, email, telefone, observacao FROM clientes ORDER BY id DESC');
        } else if ($tabela === 'funcionarios') {
            $stmt = $pdo->query('SELECT id, nome, email, telefone, funcao, status FROM funcionarios ORDER BY id DESC');
        } else {
            $stmt = $pdo->query('SELECT id, nome, preco, duracao_min, status FROM servicos ORDER BY id DESC');
        }

        jsonOut(array('ok' => true, 'dados' => $stmt->fetchAll()));
    }

    if ($acao === 'excluir') {
        $id = (int) campo('id');

        if ($id > 0) {
            $stmt = $pdo->prepare('DELETE FROM ' . $tabela . ' WHERE id = ?');
            $stmt->execute(array($id));
        }

        jsonOut(array('ok' => true));
    }

    $id = (int) campo('id');

    if ($tabela === 'clientes') {
        $nome = trim(campo('nome'));
        $email = trim(campo('email'));
        $telefone = trim(campo('telefone'));
        $observacao = trim(campo('observacao'));

        if ($nome === '' || $email === '' || $telefone === '') {
            jsonOut(array('ok' => false, 'mensagem' => 'Preencha nome, e-mail e telefone.'), 400);
        }

        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE clientes SET nome = ?, email = ?, telefone = ?, observacao = ? WHERE id = ?');
            $stmt->execute(array($nome, $email, $telefone, $observacao, $id));
        } else {
            $stmt = $pdo->prepare('INSERT INTO clientes (nome, email, telefone, observacao) VALUES (?, ?, ?, ?)');
            $stmt->execute(array($nome, $email, $telefone, $observacao));
        }
    }

    if ($tabela === 'funcionarios') {
        $nome = trim(campo('nome'));
        $email = trim(campo('email'));
        $telefone = trim(campo('telefone'));
        $funcao = trim(campo('funcao'));
        $status = campo('status', 'Ativo');

        if ($nome === '' || $funcao === '') {
            jsonOut(array('ok' => false, 'mensagem' => 'Preencha nome e função.'), 400);
        }

        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE funcionarios SET nome = ?, email = ?, telefone = ?, funcao = ?, status = ? WHERE id = ?');
            $stmt->execute(array($nome, $email, $telefone, $funcao, $status, $id));
        } else {
            $stmt = $pdo->prepare('INSERT INTO funcionarios (nome, email, telefone, funcao, status) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute(array($nome, $email, $telefone, $funcao, $status));
        }
    }

    if ($tabela === 'servicos') {
        $nome = trim(campo('nome'));
        $preco = str_replace(',', '.', campo('preco'));
        $duracao = (int) campo('duracao_min');
        $status = campo('status', 'Ativo');

        if ($nome === '' || !is_numeric($preco)) {
            jsonOut(array('ok' => false, 'mensagem' => 'Preencha serviço e preço.'), 400);
        }

        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE servicos SET nome = ?, preco = ?, duracao_min = ?, status = ? WHERE id = ?');
            $stmt->execute(array($nome, $preco, $duracao, $status, $id));
        } else {
            $stmt = $pdo->prepare('INSERT INTO servicos (nome, preco, duracao_min, status) VALUES (?, ?, ?, ?)');
            $stmt->execute(array($nome, $preco, $duracao, $status));
        }
    }

    jsonOut(array('ok' => true));
} catch (Exception $e) {
    jsonOut(array('ok' => false, 'mensagem' => 'Erro no PHP: ' . $e->getMessage()), 500);
}
