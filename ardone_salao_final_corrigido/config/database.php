<?php

require_once __DIR__ . '/app.php';

function serverConnection(): PDO
{
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8mb4';

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function connection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    initializeDatabase();

    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function initializeDatabase(): void
{
    static $initialized = false;

    if ($initialized) {
        return;
    }

    serverConnection()->exec(
        'CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
    );

    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    createTables($pdo);
    seedDatabase($pdo);

    $initialized = true;
}

function createTables(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS administradores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        email VARCHAR(160) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        email VARCHAR(160) NOT NULL UNIQUE,
        telefone VARCHAR(30) NOT NULL,
        senha VARCHAR(255) NULL,
        tipo VARCHAR(20) NOT NULL DEFAULT 'Cliente',
        observacao TEXT,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS funcionarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        email VARCHAR(160),
        telefone VARCHAR(30),
        funcao VARCHAR(90) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'Ativo',
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS servicos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        preco DECIMAL(10,2) NOT NULL DEFAULT 0,
        duracao_min INT NOT NULL DEFAULT 60,
        status VARCHAR(20) NOT NULL DEFAULT 'Ativo',
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS agendamentos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_id INT NOT NULL,
        funcionario_id INT NOT NULL,
        servico_id INT NOT NULL,
        data_agendamento DATE NOT NULL,
        hora_agendamento TIME NOT NULL,
        status VARCHAR(30) NOT NULL DEFAULT 'Agendado',
        observacao TEXT,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
        FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id) ON DELETE CASCADE,
        FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE CASCADE,
        UNIQUE KEY unico_funcionario_horario (funcionario_id, data_agendamento, hora_agendamento)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function seedDatabase(PDO $pdo): void
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM administradores WHERE email = ?');
    $stmt->execute(['admin@ardone.com.br']);

    if ((int) $stmt->fetchColumn() === 0) {
        $stmt = $pdo->prepare('INSERT INTO administradores (nome, email, senha) VALUES (?, ?, ?)');
        $stmt->execute([
            'Administrador',
            'admin@ardone.com.br',
            password_hash('123456', PASSWORD_DEFAULT),
        ]);
    }

    if ((int) $pdo->query('SELECT COUNT(*) FROM servicos')->fetchColumn() === 0) {
        $servicos = [
            ['Corte feminino', 70, 60, 'Ativo'],
            ['Escova modelada', 55, 45, 'Ativo'],
            ['Manicure', 35, 40, 'Ativo'],
            ['Hidratação capilar', 95, 75, 'Ativo'],
            ['Design de sobrancelhas', 45, 30, 'Ativo'],
        ];

        $stmt = $pdo->prepare('INSERT INTO servicos (nome, preco, duracao_min, status) VALUES (?, ?, ?, ?)');

        foreach ($servicos as $servico) {
            $stmt->execute($servico);
        }
    }

    if ((int) $pdo->query('SELECT COUNT(*) FROM funcionarios')->fetchColumn() === 0) {
        $funcionarios = [
            ['Ana Souza', 'ana@ardone.com.br', '(21) 98888-1001', 'Cabeleireiro', 'Ativo'],
            ['Carlos Lima', 'carlos@ardone.com.br', '(21) 98888-1002', 'Manicure', 'Ativo'],
            ['Bruna Alves', 'bruna@ardone.com.br', '(21) 98888-1003', 'Estética', 'Ativo'],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO funcionarios (nome, email, telefone, funcao, status) VALUES (?, ?, ?, ?, ?)'
        );

        foreach ($funcionarios as $funcionario) {
            $stmt->execute($funcionario);
        }
    }
}
