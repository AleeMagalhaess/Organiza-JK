<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isset($_SESSION['admin_logado'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'];
    $nome = $_POST['nome'];
    $turma = $_POST['turma'];
    $data_nascimento = $_POST['data_nascimento'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO alunos (matricula, nome, turma, data_nascimento) VALUES (?, ?, ?, ?)");
        $stmt->execute([$matricula, $nome, $turma, $data_nascimento]);
        $sucesso = "Aluno cadastrado com sucesso!";
    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar aluno: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Aluno</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Aluno</h1>
        
        <?php if (isset($sucesso)): ?>
            <div class="alert success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        
        <?php if (isset($erro)): ?>
            <div class="alert error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="matricula">Número de Matrícula:</label>
                <input type="text" id="matricula" name="matricula" required>
            </div>
            
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="turma">Turma:</label>
                <input type="text" id="turma" name="turma" required>
            </div>
            
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
            
            <button type="submit" class="btn">Cadastrar Aluno</button>
        </form>
        
        <a href="dashboard.php" class="btn">Voltar</a>
    </div>
</body>
</html>