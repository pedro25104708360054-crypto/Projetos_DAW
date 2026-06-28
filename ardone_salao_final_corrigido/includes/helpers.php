<?php

function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function isPost(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function postValue(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
}

function getValue(string $key, mixed $default = ''): mixed
{
    return $_GET[$key] ?? $default;
}

function flash(string $type, ?string $message = null): ?string
{
    startSession();

    if ($message !== null) {
        $_SESSION['flash'][$type] = $message;
        return null;
    }

    $message = $_SESSION['flash'][$type] ?? null;
    unset($_SESSION['flash'][$type]);

    return $message;
}

function money(mixed $value): string
{
    return 'R$ ' . number_format((float) $value, 2, ',', '.');
}

function brDate(?string $date): string
{
    return $date ? date('d/m/Y', strtotime($date)) : '-';
}

function validEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
