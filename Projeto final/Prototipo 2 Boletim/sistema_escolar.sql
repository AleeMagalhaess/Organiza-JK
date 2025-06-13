CREATE DATABASE sistema_escolar;
USE sistema_escolar;

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    nome VARCHAR(100) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    data_nascimento DATE NOT NULL
);

CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    disciplina VARCHAR(50) NOT NULL,
    nota DECIMAL(4,2) NOT NULL,
    trimestre INT NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id)
);

CREATE TABLE usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);