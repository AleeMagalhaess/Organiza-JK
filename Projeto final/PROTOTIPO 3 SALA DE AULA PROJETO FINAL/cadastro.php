<?php
require_once 'config.php';

// Redirecionar usuários já logados
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$erros = [];
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $tipo = 'aluno'; // Padrão como aluno, pode mudar conforme necessidade

    // Validações
    if (empty($nome)) {
        $erros[] = "O nome é obrigatório.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }

    if (strlen($senha) < 6) {
        $erros[] = "A senha deve ter pelo menos 6 caracteres.";
    }

    if ($senha !== $confirmar_senha) {
        $erros[] = "As senhas não coincidem.";
    }

    // Verificar se e-mail já existe
    if (empty($erros)) {
        $conn = conectarDB();
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            $erros[] = "Este e-mail já está cadastrado.";
        }
    }

    // Se não houver erros, cadastrar usuário
    if (empty($erros)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $conn = conectarDB();
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senha_hash, $tipo);
        
        if ($stmt->execute()) {
            $sucesso = true;
        } else {
            $erros[] = "Erro ao cadastrar usuário. Por favor, tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Organiza JK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header h1 {
            color: #4285f4;
            margin: 0;
        }
        
        .register-header i {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #4285f4;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        
        button[type="submit"] {
            background-color: #34a853;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            width: 100%;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 15px;
        }
        
        button[type="submit"]:hover {
            background-color: #2d8e47;
        }
        
        .login-btn {
            background-color: #4285f4;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            width: 100%;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            display: block;
            text-decoration: none;
        }
        
        .login-btn:hover {
            background-color: #3367d6;
        }
        
        .error-message {
            color: #db4437;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success-message {
            color: #34a853;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .error-list {
            color: #db4437;
            margin-bottom: 20px;
            padding-left: 20px;
        }
        
        .error-list li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h1>Criar Conta</h1>
        </div>
        
        <?php if ($sucesso): ?>
            <div class="success-message">
                Cadastro realizado com sucesso!<br>
                <a href="login.php" class="login-btn">Fazer Login</a>
            </div>
        <?php else: ?>
            <?php if (!empty($erros)): ?>
                <ul class="error-list">
                    <?php foreach ($erros as $erro): ?>
                        <li><?php echo htmlspecialchars($erro); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" required value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha (mínimo 6 caracteres):</label>
                    <input type="password" id="senha" name="senha" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha:</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required minlength="6">
                </div>
                
                <button type="submit">Cadastrar</button>
                <a href="login.php" class="login-btn">Já tem conta? Faça Login</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>