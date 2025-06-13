<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isset($_SESSION['aluno_id'])) {
    header('Location: ../login.php');
    exit();
}

$aluno_id = $_SESSION['aluno_id'];

// Buscar informações do aluno
$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$stmt->execute([$aluno_id]);
$aluno = $stmt->fetch();

// Buscar notas do aluno (atualizado para trimestre)
$stmt = $pdo->prepare("SELECT disciplina, trimestre, nota FROM notas WHERE aluno_id = ? ORDER BY trimestre, disciplina");
$stmt->execute([$aluno_id]);
$notas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boletim Escolar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Boletim Escolar</h1>
        
        <div class="aluno-info">
            <h2><?php echo htmlspecialchars($aluno['nome']); ?></h2>
            <p>Matrícula: <?php echo htmlspecialchars($aluno['matricula']); ?></p>
            <p>Turma: <?php echo htmlspecialchars($aluno['turma']); ?></p>
        </div>
        
        <table class="boletim-table">
    <thead>
        <tr>
            <th>Disciplina</th>
            <th>1º Tri</th>
            <th>2º Tri</th>
            <th>3º Tri</th>
            <th>Média</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $disciplinas = [];
        foreach ($notas as $nota) {
            $disciplinas[$nota['disciplina']][$nota['trimestre']] = $nota['nota'];
        }
        
        foreach ($disciplinas as $disciplina => $trimestres):
            $media = array_sum($trimestres) / count($trimestres);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($disciplina); ?></td>
            <td><?php echo $trimestres['1'] ?? '-'; ?></td>
            <td><?php echo $trimestres['2'] ?? '-'; ?></td>
            <td><?php echo $trimestres['3'] ?? '-'; ?></td>
            <td><?php echo number_format($media, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        
        <a href="../logout.php" class="btn">Sair</a>
    </div>
</body>
</html>