-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS saep;
USE saep;

-- 1. Tabela de Usuários (para autenticação no sistema)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL -- Armazenar hash da senha na aplicação
);

-- 2. Tabela de Tutores (com CPF criptografado)
CREATE TABLE tutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARBINARY(255) NOT NULL, -- Tipo VARBINARY/VARCHAR para guardar o dado criptografado
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100)
);

-- 3. Tabela de Pets (associados obrigatoriamente a um tutor via FK)
CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    especie VARCHAR(30) NOT NULL,
    raca VARCHAR(50),
    idade INT,
    tutor_id INT NOT NULL,
    CONSTRAINT fk_pet_tutor FOREIGN KEY (tutor_id) REFERENCES tutores(id) ON DELETE CASCADE
);

-- 4. Tabela de Agendamentos (associados a um pet via FK)
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_agendamento DATE NOT NULL,
    horario TIME NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    pet_id INT NOT NULL,
    CONSTRAINT fk_agendamento_pet FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);

-- ==========================================================
-- INSERÇÃO DE DADOS (Mínimo de 3 registros por tabela)
-- ==========================================================

-- Inserindo 3 Usuários
INSERT INTO usuarios (nome, email, senha) VALUES
('Dra. Ana Silva', 'ana@clinica.com', 'hash_senha_123'),
('Carlos Recepção', 'carlos@clinica.com', 'hash_senha_456'),
('Dr. Marcos Souza', 'marcos@clinica.com', 'hash_senha_789');

-- Inserindo 3 Tutores (criptografando o CPF com AES_ENCRYPT e uma chave secreta)
INSERT INTO tutores (nome, cpf, telefone, email) VALUES
('João Pereira', AES_ENCRYPT('111.222.333-44', 'chave_secreta_lgpd'), '(81) 99999-1111', 'joao@email.com'),
('Maria Oliveira', AES_ENCRYPT('555.666.777-88', 'chave_secreta_lgpd'), '(81) 98888-2222', 'maria@email.com'),
('Pedro Santos', AES_ENCRYPT('999.000.111-22', 'chave_secreta_lgpd'), '(81) 97777-3333', 'pedro@email.com');

-- Inserindo 3 Pets
INSERT INTO pets (nome, especie, raca, idade, tutor_id) VALUES
('Rex', 'Cachorro', 'Labrador', 3, 1),
('Mia', 'Gato', 'Siamês', 2, 2),
('Thor', 'Cachorro', 'Bulldog', 4, 3);

-- Inserindo 3 Agendamentos
INSERT INTO agendamentos (data_agendamento, horario, motivo, pet_id) VALUES
('2026-11-25', '09:00:00', 'Vacinação Anual', 1),
('2026-11-25', '10:30:00', 'Consulta de Rotina', 2),
('2026-11-26', '14:00:00', 'Exame de Sangue', 3);
