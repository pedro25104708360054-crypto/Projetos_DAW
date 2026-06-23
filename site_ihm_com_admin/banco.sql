CREATE DATABASE IF NOT EXISTS site_ihm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE site_ihm;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(160),
    telefone VARCHAR(30),
    observacao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(160),
    telefone VARCHAR(30),
    funcao VARCHAR(90) NOT NULL,
    status ENUM('Ativo','Inativo') DEFAULT 'Ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    categoria VARCHAR(90),
    preco DECIMAL(10,2) DEFAULT 0,
    duracao_min INT DEFAULT 60,
    status ENUM('Ativo','Inativo') DEFAULT 'Ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    funcionario_id INT NULL,
    servico_id INT NOT NULL,
    data_agendamento DATE NOT NULL,
    hora_agendamento TIME NOT NULL,
    status ENUM('Pendente','Confirmado','Cancelado','Finalizado') DEFAULT 'Pendente',
    observacao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id) ON DELETE SET NULL,
    FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE CASCADE
);

-- Login admin padrão: admin@admin.com | senha: password
INSERT INTO admins (nome, email, senha)
SELECT 'Administrador', 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.'
WHERE NOT EXISTS (SELECT 1 FROM admins WHERE email = 'admin@admin.com');

INSERT INTO funcionarios (nome, email, telefone, funcao, status)
SELECT * FROM (
    SELECT 'Ana Souza', 'ana@studio.com', '(21) 99999-1001', 'Cabeleireiro', 'Ativo' UNION ALL
    SELECT 'Carlos Lima', 'carlos@studio.com', '(21) 99999-1002', 'Manicure', 'Ativo' UNION ALL
    SELECT 'Bruna Alves', 'bruna@studio.com', '(21) 99999-1003', 'Estética', 'Ativo'
) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM funcionarios LIMIT 1);

INSERT INTO servicos (nome, categoria, preco, duracao_min, status)
SELECT * FROM (
    SELECT 'Corte Feminino', 'Cabelo', 65.00, 60, 'Ativo' UNION ALL
    SELECT 'Escova', 'Cabelo', 55.00, 45, 'Ativo' UNION ALL
    SELECT 'Manicure', 'Unhas', 35.00, 40, 'Ativo' UNION ALL
    SELECT 'Hidratação', 'Tratamento', 90.00, 75, 'Ativo'
) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM servicos LIMIT 1);

INSERT INTO clientes (nome, email, telefone, observacao)
SELECT * FROM (
    SELECT 'Cliente Exemplo 1', 'cliente1@email.com', '(21) 98888-0001', 'Preferência por horário da tarde' UNION ALL
    SELECT 'Cliente Exemplo 2', 'cliente2@email.com', '(21) 98888-0002', 'Cliente recorrente'
) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM clientes LIMIT 1);
