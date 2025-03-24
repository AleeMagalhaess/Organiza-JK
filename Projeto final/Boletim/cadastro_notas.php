

<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aluno_id = $_POST["aluno_id"];
    $disciplina = $_POST["disciplina"];
    $nota = $_POST["nota"];

    $sql = "INSERT INTO notas (aluno_id, disciplina, nota) VALUES ('$aluno_id', '$disciplina', '$nota')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nota cadastrada com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Listar alunos para selecionar
$alunos = $conn->query("SELECT * FROM alunos");
?>

<form method="POST">
    Aluno:
    <select name="aluno_id" required>
        <?php while ($aluno = $alunos->fetch_assoc()) { ?>
            <option value="<?= $aluno['id'] ?>"><?= $aluno['nome'] ?></option>
        <?php } ?>
    </select>

    Disciplina: <input type="text" name="disciplina" required>
    Nota: <input type="number" name="nota" step="0.1" required>
    <input type="submit" value="Cadastrar Nota">
</form>
