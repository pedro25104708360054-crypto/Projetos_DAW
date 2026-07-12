<?php

function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function jsonOut($dados, $codigo = 200)
{
    http_response_code($codigo);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    echo json_encode($dados);
    exit;
}

function campo($nome, $padrao = '')
{
    if (isset($_POST[$nome])) {
        return $_POST[$nome];
    }

    if (isset($_GET[$nome])) {
        return $_GET[$nome];
    }

    return $padrao;
}

function adminLogado()
{
    startSession();
    return isset($_SESSION['admin_id']);
}

function clienteLogado()
{
    startSession();
    return isset($_SESSION['cliente_id']);
}

function exigirAdmin()
{
    if (!adminLogado()) {
        jsonOut(array('ok' => false, 'mensagem' => 'Acesso negado. Faça login novamente.'), 401);
    }
}

function exigirCliente()
{
    if (!clienteLogado()) {
        jsonOut(array('ok' => false, 'mensagem' => 'Acesso negado. Faça login novamente.'), 401);
    }
}
