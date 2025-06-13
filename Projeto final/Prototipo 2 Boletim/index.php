<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<div class="container">
    <h1>Sistema de Boletim Escolar</h1>
    
    <div class="card">
        <h2>Área do Aluno</h2>
        <p>Para acessar seu boletim, informe sua matrícula e data de nascimento.</p>
        <a href="login.php" class="btn">Acessar Boletim</a>
    </div>
    
    <div class="card">
        <h2>Área da Escola</h2>
        <p>Administradores podem acessar o painel para cadastrar alunos e notas.</p>
        <a href="login_admin.php" class="btn">Painel Administrativo</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>