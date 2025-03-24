<?php
include 'conexao.php';

$sql = "SELECT alunos.nome, alunos.turma, notas.disciplina, notas.nota 
        FROM alunos 
        JOIN notas ON alunos.id = notas.aluno_id 
        ORDER BY alunos.nome, notas.disciplina";

$result = $conn->query($sql);
?>

<table border="1">
    <tr>
        <th>Nome</th>
        <th>Turma</th>
        <th>Disciplina</th>
        <th>Nota</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row["nome"] ?></td>
            <td><?= $row["turma"] ?></td>
            <td><?= $row["disciplina"] ?></td>
            <td><?= $row["nota"] ?></td>
        </tr>
    <?php } ?>
</table>
