<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Verificar se é admin
if (!isset($_SESSION['admin_logado'])) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Painel Administrativo</h1>
        
        <div class="admin-actions">
            <a href="cadastrar_aluno.php" class="btn">Cadastrar Aluno</a>
            <a href="registrar_nota.php" class="btn">Registrar Notas</a>
            <a href="../logout.php" class="btn">Sair</a>
        </div>
    </div>
</body>
</html>