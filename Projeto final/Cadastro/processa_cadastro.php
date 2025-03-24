<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'sistema_cadastro';
$username = 'root';
$password = '';

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validações
        $erros = [];

        // Nome
        $nome = trim($_POST['nome']);
        if (empty($nome)) {
            $erros[] = "O nome é obrigatório.";
        }

        // E-mail
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "E-mail inválido.";
        } else {
            // Verifica se o e-mail já existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $erros[] = "Este e-mail já está cadastrado.";
            }
        }

        // Senha
        $senha = $_POST['senha'];
        if (strlen($senha) < 6) {
            $erros[] = "A senha deve ter pelo menos 6 caracteres.";
        }

        // Confirmação de senha
        if ($senha !== $_POST['confirmar_senha']) {
            $erros[] = "As senhas não coincidem.";
        }

        // Termos
        if (!isset($_POST['termos'])) {
            $erros[] = "Você deve aceitar os termos de uso.";
        }

        // Se não houver erros, insere no banco de dados
        if (empty($erros)) {
            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Prepara os dados
            $dataNascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
            $telefone = !empty($_POST['telefone']) ? $_POST['telefone'] : null;

            // Insere no banco de dados
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, data_nascimento, telefone) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash, $dataNascimento, $telefone]);

            // Redireciona para página de sucesso
            header("Location: cadastro_sucesso.html");
            exit();
        }
    }
} catch (PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}

// Se houver erros ou não for POST, mostra o formulário novamente
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Erro no Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Erros no Cadastro</h1>
        
        <?php if (!empty($erros)): ?>
            <div class="error-messages">
                <?php foreach ($erros as $erro): ?>
                    <p class="error"><?php echo htmlspecialchars($erro); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <p>Por favor, <a href="cadastro.html">volte ao formulário</a> e corrija os erros.</p>
    </div>
</body>
</html>