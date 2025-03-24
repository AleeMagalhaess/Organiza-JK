<?php
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se deseja destruir a sessão completamente, apague também o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Remove o cookie "lembrar"
setcookie('lembrar', '', time() - 3600, '/');

// Redireciona para a página de login
header("Location: login.html");
exit();
?>