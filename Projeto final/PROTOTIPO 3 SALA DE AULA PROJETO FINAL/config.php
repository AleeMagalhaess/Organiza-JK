<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'jk123456');
define('DB_NAME', 'organiza_jk');

// Inicia a sessão
session_start();

// Conexão com o banco de dados
function conectarDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Função para gerar código de turma
function gerarCodigoTurma() {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $codigo = '';
    for ($i = 0; $i < 6; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

// Verifica se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Função para fazer upload de arquivos
function uploadArquivo($arquivo, $pasta = 'uploads/') {
    // Verifica se a pasta existe, se não, tenta criar
    if (!file_exists($pasta)) {
        if (!mkdir($pasta, 0755, true)) {
            return ['error' => 'Não foi possível criar o diretório de uploads'];
        }
    }

    // Verifica se a pasta é gravável
    if (!is_writable($pasta)) {
        return ['error' => 'O diretório de uploads não tem permissão de escrita'];
    }

    // Gera um nome único para o arquivo
    $nomeArquivo = uniqid() . '_' . basename($arquivo['name']);
    $caminhoCompleto = $pasta . $nomeArquivo;
    
    // Tenta mover o arquivo
    if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
        return [
            'nome' => $arquivo['name'],
            'caminho' => $caminhoCompleto
        ];
    } else {
        // Log do erro para diagnóstico
        error_log("Erro ao mover arquivo: " . print_r(error_get_last(), true));
        return ['error' => 'Falha ao mover o arquivo enviado'];
    }
}
?>