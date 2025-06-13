CREATE DATABASE organiza_jk;
USE organiza_jk;

-- Tabela de usuários (professores/alunos)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('professor', 'aluno') NOT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de turmas
CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    materia VARCHAR(100),
    codigo_acesso VARCHAR(10) NOT NULL UNIQUE,
    professor_id INT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (professor_id) REFERENCES usuarios(id)
);

-- Tabela de relação usuário-turma (para alunos matriculados)
CREATE TABLE usuario_turma (
    usuario_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_entrada DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, turma_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);

-- Tabela de materiais
CREATE TABLE materiais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    turma_id INT NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    tipo ENUM('arquivo', 'texto') NOT NULL,
    nome_arquivo VARCHAR(255),
    caminho_arquivo VARCHAR(255),
    conteudo_texto TEXT,
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);


INSERT INTO usuarios (nome, email, senha, tipo, data_cadastro) 
VALUES (
    'Admin', 
    'admin@escola.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- senha é "password"
    'professor', 
    NOW()
);

select * from usuarios
 
