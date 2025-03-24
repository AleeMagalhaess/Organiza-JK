<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $turma = $_POST["turma"];

    $sql = "INSERT INTO alunos (nome, turma) VALUES ('$nome', '$turma')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Aluno cadastrado com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<form method="POST">
    Nome: <input type="text" name="nome" required>
    Turma: <input type="text" name="turma" required>
    <input type="submit" value="Cadastrar">
</form>