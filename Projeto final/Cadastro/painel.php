<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

// Verifica o cookie "lembrar" para login automático
if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['lembrar'])) {
    list($usuario_id, $token) = explode(':', $_COOKIE['lembrar']);
    
    // Configurações do banco de dados
    $host = 'localhost';
    $dbname = 'sistema_cadastro';
    $username = 'root';
    $password = 'jk123456';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
        $usuario = $stmt->fetch();
        
        if ($usuario && hash('sha256', $usuario['senha']) === $token) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
        }
    } catch (PDOException $e) {
        // Tratar erro
    }
}

// Se ainda não estiver logado, redireciona
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
        <p>Você está logado em nosso sistema.</p>
        
        <div class="user-actions">
            <a href="editar_perfil.php" class="btn-cadastrar">Editar Perfil</a>
            <a href="logout.php" class="btn-cadastrar" style="background-color: #f44336;">Sair</a>
        </div>
    </div>
</body>
</html>