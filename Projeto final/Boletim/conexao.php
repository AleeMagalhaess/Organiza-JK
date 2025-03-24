<?php
$host = "localhost";
$user = "root";  // Alterar se necessário
$pass = "";  // Senha do MySQL
$db = "escola";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
