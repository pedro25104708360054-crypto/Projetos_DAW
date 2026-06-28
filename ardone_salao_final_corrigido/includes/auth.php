<?php

require_once __DIR__ . '/helpers.php';

function adminLogged(): bool
{
    startSession();
    return isset($_SESSION['admin_id']);
}

function userLogged(): bool
{
    startSession();
    return isset($_SESSION['cliente_id']);
}

function requireAdmin(): void
{
    if (!adminLogged()) {
        redirect('admin_login.php');
    }
}

function requireUser(): void
{
    if (!userLogged()) {
        redirect('usuario_login.php');
    }
}

function loginAdmin(array $admin): void
{
    startSession();
    session_regenerate_id(true);

    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_nome'] = $admin['nome'];
}

function loginUser(array $cliente): void
{
    startSession();
    session_regenerate_id(true);

    $_SESSION['cliente_id'] = (int) $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome'];
}
