<?php
require_once 'includes/config.php';

// DEFINA AQUI SUAS CREDENCIAIS
$usuario_admin = 'escola123'; // Troque pelo seu usuário
$senha_admin = 'boletim456';  // Troque pela sua senha

// Cria o hash seguro da senha
$senha_hash = password_hash($senha_admin, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios_admin (usuario, senha) VALUES (?, ?)");
    $stmt->execute([$usuario_admin, $senha_hash]);
    
    echo "Administrador criado com sucesso!<br>";
    echo "<strong>Credenciais:</strong><br>";
    echo "Usuário: ".htmlspecialchars($usuario_admin)."<br>";
    echo "Senha: ".htmlspecialchars($senha_admin)."<br><br>";
    echo "<span style='color:red;font-weight:bold;'>DELETE ESTE ARQUIVO (criar_admin.php) IMEDIATAMENTE APÓS USAR!</span>";
} catch (PDOException $e) {
    echo "Erro: ".$e->getMessage();
}
?>