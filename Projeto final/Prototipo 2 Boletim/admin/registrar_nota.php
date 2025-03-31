<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

verificarAdmin();

// Buscar alunos para o select
$alunos = $pdo->query("SELECT id, nome, matricula FROM alunos ORDER BY nome")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno_id = $_POST['aluno_id'];
    $disciplina = $_POST['disciplina'];
    $nota = $_POST['nota'];
    $trimestre = $_POST['trimestre'];  // Alterado para trimestre
    
    try {
        $stmt = $pdo->prepare("INSERT INTO notas (aluno_id, disciplina, nota, trimestre) VALUES (?, ?, ?, ?)");
        $stmt->execute([$aluno_id, $disciplina, $nota, $trimestre]);
        $sucesso = "Nota registrada com sucesso!";
    } catch (PDOException $e) {
        $erro = "Erro ao registrar nota: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Registrar Notas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Notas</h1>
        
        <?php if (isset($sucesso)): ?>
            <div class="alert success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        
        <?php if (isset($erro)): ?>
            <div class="alert error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="aluno_id">Aluno:</label>
                <select id="aluno_id" name="aluno_id" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?php echo $aluno['id']; ?>">
                            <?php echo htmlspecialchars($aluno['nome'] . ' - ' . $aluno['matricula']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="disciplina">Disciplina:</label>
                <input type="text" id="disciplina" name="disciplina" required>
            </div>
            
            <div class="form-group">
                <label for="nota">Nota:</label>
                <input type="number" id="nota" name="nota" step="0.01" min="0" max="10" required>
            </div>
            
            <div class="form-group">
    <label for="trimestre">Trimestre:</label>
    <select id="trimestre" name="trimestre" required>
        <option value="1">1º Trimestre</option>
        <option value="2">2º Trimestre</option>
        <option value="3">3º Trimestre</option>
    </select>
</div>
            
            <button type="submit" class="btn">Registrar Nota</button>
        </form>
        
        <a href="dashboard.php" class="btn">Voltar</a>
    </div>
</body>
</html>