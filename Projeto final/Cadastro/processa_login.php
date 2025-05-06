<?php
session_start();

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'sistema_cadastro';
$username = 'root';
$password = 'jk123456';

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        
        // Busca o usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            // Lembrar de mim
            if (isset($_POST['lembrar'])) {
                $cookie_valor = $usuario['id'] . ':' . hash('sha256', $usuario['senha']);
                setcookie('lembrar', $cookie_valor, time() + 86400 * 30, '/');
            }
            
            header("Location: painel.php");
            exit();
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    }
} catch (PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Erro no Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Erro no Login</h1>
        
        <?php if (isset($erro)): ?>
            <p class="error"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>
        
        <p>Por favor, <a href="login.html">tente novamente</a> ou <a href="recuperar_s