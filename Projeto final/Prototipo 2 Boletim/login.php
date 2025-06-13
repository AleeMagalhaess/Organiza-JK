<?php
session_start();
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'];
    $data_nascimento = $_POST['data_nascimento'];
    
    $stmt = $pdo->prepare("SELECT * FROM alunos WHERE matricula = ? AND data_nascimento = ?");
    $stmt->execute([$matricula, $data_nascimento]);
    $aluno = $stmt->fetch();
    
    if ($aluno) {
        $_SESSION['aluno_id'] = $aluno['id'];
        header('Location: aluno/boletim.php');
        exit();
    } else {
        $erro = "Matrícula ou data de nascimento incorretos!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login do Aluno</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login do Aluno</h1>
        
        <?php if (isset($erro)): ?>
            <div class="alert error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="matricula">Número de Matrícula:</label>
                <input type="text" id="matricula" name="matricula" required>
            </div>
            
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
            
            <button type="submit" class="btn">Acessar Boletim</button>
        </form>
    </div>
</body>
</html>