-- Criação do banco de dados (se necessário)
CREATE DATABASE IF NOT EXISTS evento_rsvp;
USE evento_rsvp;

-- Tabela de convidados
CREATE TABLE IF NOT EXISTS convidados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    data_confirmacao DATETIME NOT NULL
);

-- Tabela de usuários administrativos
CREATE TABLE IF NOT EXISTS usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) DEFAULT 'Administrador',
    usuario VARCHAR(100) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL
);

-- Inserindo um usuário padrão (admin / admin123)
-- Hash gerado com password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO usuarios_admin (nome, usuario, senha_hash) VALUES 
('Admin Principal', 'admin', '$2y$12$.4mn6y1ePqCeODY2KJJObujSkU53WXeaiCDHifnmgW4ETlhKGAXTm');
