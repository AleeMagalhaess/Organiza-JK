CREATE DATABASE escola;
USE escola;

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    turma VARCHAR(50) NOT NULL
);

CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT,
    disciplina VARCHAR(100),
    nota DECIMAL(5,2),
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
);
