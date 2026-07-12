<?php

date_default_timezone_set('America/Sao_Paulo');

const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';
const DB_NAME = 'ardone_salao_db';
const DB_USER = 'root';
const DB_PASS = '';

function connection()
{
    $host = DB_HOST;
    $porta = DB_PORT;
    $banco = DB_NAME;
    $usuario = DB_USER;
    $senha = DB_PASS;

    $dsn = "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4";

    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}
