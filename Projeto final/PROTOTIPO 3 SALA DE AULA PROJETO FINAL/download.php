<?php
require_once 'config.php';
verificarLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$material_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Verificar se o usuário tem acesso a este material
$conn = conectarDB();
$stmt = $conn->prepare("SELECT m.* FROM materiais m 
                       JOIN turmas t ON m.turma_id = t.id 
                       LEFT JOIN usuario_turma ut ON t.id = ut.turma_id 
                       WHERE m.id = ? AND (t.professor_id = ? OR ut.usuario_id = ?)");
$stmt->bind_param("iii", $material_id, $usuario_id, $usuario_id);
$stmt->execute();
$material = $stmt->get_result()->fetch_assoc();

if (!$material || $material['tipo'] !== 'arquivo' || !file_exists($material['caminho_arquivo'])) {
    header("Location: index.php");
    exit();
}

// Configurar headers para download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($material['nome_arquivo']) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($material['caminho_arquivo']));
flush(); // Limpar buffer de saída
readfile($material['caminho_arquivo']);
exit;
?>