<?php
require_once 'config.php';
verificarLogin();

// Verificar se o ID da turma foi fornecido
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$turma_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];
$usuario_tipo = $_SESSION['usuario_tipo'];

// Conexão com o banco de dados
$conn = conectarDB();

// Verificar se o usuário tem acesso a esta turma
if ($usuario_tipo === 'professor') {
    $stmt = $conn->prepare("SELECT * FROM turmas WHERE id = ? AND professor_id = ?");
} else {
    $stmt = $conn->prepare("SELECT t.* FROM turmas t JOIN usuario_turma ut ON t.id = ut.turma_id WHERE t.id = ? AND ut.usuario_id = ?");
}
$stmt->bind_param("ii", $turma_id, $usuario_id);
$stmt->execute();
$turma = $stmt->get_result()->fetch_assoc();

if (!$turma) {
    header("Location: index.php");
    exit();
}

// Obter materiais da turma
$stmt = $conn->prepare("SELECT * FROM materiais WHERE turma_id = ? ORDER BY data_upload DESC");
$stmt->bind_param("i", $turma_id);
$stmt->execute();
$materiais = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Processar adição de material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_material'])) {
    $titulo = trim($_POST['titulo']);
    $tipo = $_POST['tipo'];
    $erro = null;
    
    if ($tipo === 'arquivo' && isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $upload = uploadArquivo($_FILES['arquivo']);
        
        if (isset($upload['error'])) {
            $erro = $upload['error'];
        } elseif ($upload) {
            $stmt = $conn->prepare("INSERT INTO materiais (turma_id, titulo, tipo, nome_arquivo, caminho_arquivo) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $turma_id, $titulo, $tipo, $upload['nome'], $upload['caminho']);
        }
    } elseif ($tipo === 'texto' && !empty(trim($_POST['conteudo']))) {
        $conteudo = trim($_POST['conteudo']);
        $stmt = $conn->prepare("INSERT INTO materiais (turma_id, titulo, tipo, conteudo_texto) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $turma_id, $titulo, $tipo, $conteudo);
    } else {
        $erro = "Preencha todos os campos obrigatórios!";
    }
    
    if (!isset($erro) && isset($stmt) && $stmt->execute()) {
        header("Location: turma.php?id=" . $turma_id);
        exit();
    } elseif (!isset($erro)) {
        $erro = "Erro ao adicionar material: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($turma['nome']); ?> - Organiza JK</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos para mensagens de erro */
        .error-message {
            color: #d32f2f;
            background-color: #fde0e0;
            padding: 10px 15px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 4px solid #d32f2f;
        }
        /* Estilos para mensagens de sucesso */
        .success-message {
            color: #388e3c;
            background-color: #ebf5eb;
            padding: 10px 15px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 4px solid #388e3c;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><i class="fas fa-chalkboard-teacher"></i> Organiza JK</h1>
            <nav>
                <span class="user-info">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                <a href="index.php" class="header-btn"><i class="fas fa-arrow-left"></i> Voltar</a>
                <a href="logout.php" class="header-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container" id="classroom-detail-container">
            <h2 id="detail-class-name"><?php echo htmlspecialchars($turma['nome']); ?></h2>
            
            <?php if ($_SESSION['usuario_tipo'] === 'professor'): ?>
                <div class="class-actions">
                    <button id="add-material-btn" class="header-btn"><i class="fas fa-upload"></i> Adicionar Material</button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($erro)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>
            
            <h3><i class="fas fa-folder-open"></i> Materiais da Turma</h3>
            <div id="materials-list">
                <?php if (empty($materiais)): ?>
                    <p class="no-materials-message"><i class="fas fa-box-open"></i> Nenhum material adicionado a esta turma ainda.</p>
                <?php else: ?>
                    <?php foreach ($materiais as $material): ?>
                        <div class="material-item" onclick="<?php echo $material['tipo'] === 'texto' ? "viewTextMaterial('" . htmlspecialchars(addslashes($material['titulo'])) . "', `" . htmlspecialchars(addslashes($material['conteudo_texto'])) . "`)" : "window.location.href='download.php?id=" . $material['id'] . "'"; ?>">
                            <i class="<?php 
                                if ($material['tipo'] === 'texto') {
                                    echo 'fas fa-file-lines material-icon';
                                } else {
                                    $ext = pathinfo($material['nome_arquivo'], PATHINFO_EXTENSION);
                                    switch (strtolower($ext)) {
                                        case 'pdf': echo 'fas fa-file-pdf material-icon'; break;
                                        case 'doc':
                                        case 'docx': echo 'fas fa-file-word material-icon'; break;
                                        case 'xls':
                                        case 'xlsx': echo 'fas fa-file-excel material-icon'; break;
                                        case 'ppt':
                                        case 'pptx': echo 'fas fa-file-powerpoint material-icon'; break;
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                        case 'gif': echo 'fas fa-file-image material-icon'; break;
                                        case 'zip':
                                        case 'rar': echo 'fas fa-file-archive material-icon'; break;
                                        case 'txt': echo 'fas fa-file-alt material-icon'; break;
                                        default: echo 'fas fa-file material-icon';
                                    }
                                }
                            ?>"></i>
                            <div class="material-info">
                                <span class="material-title"><?php echo htmlspecialchars($material['titulo']); ?></span>
                                <span class="material-filename">
                                    <?php if ($material['tipo'] === 'texto'): ?>
                                        Conteúdo em texto
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($material['nome_arquivo']); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Modal Adicionar Material -->
    <div id="add-material-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('add-material-modal')">&times;</span>
            <h2>Adicionar Novo Material</h2>
            <form id="add-material-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="adicionar_material" value="1">
                
                <label for="material-title">Título do Material:</label>
                <input type="text" id="material-title" name="titulo" required>

                <div class="material-type-selector">
                    <label>Tipo de Material:</label>
                    <input type="radio" id="material-type-file" name="tipo" value="arquivo" checked>
                    <label for="material-type-file">Arquivo</label>
                    <input type="radio" id="material-type-text" name="tipo" value="texto">
                    <label for="material-type-text">Texto</label>
                </div>

                <div id="file-input-container">
                    <label for="material-file">Arquivo:</label>
                    <input type="file" id="material-file" name="arquivo" required>
                    <small class="info">Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, JPEG, PNG, TXT, ZIP (Max. 10MB)</small>
                </div>

                <div id="text-input-container" style="display: none;">
                    <label for="material-text-content">Conteúdo do Texto:</label>
                    <textarea id="material-text-content" name="conteudo" rows="6"></textarea>
                    <small class="info">Digite ou cole o conteúdo do material aqui.</small>
                </div>

                <button type="submit">Adicionar Material</button>
            </form>
        </div>
    </div>

    <!-- Modal Visualizar Texto -->
    <div id="view-text-material-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('view-text-material-modal')">&times;</span>
            <h2 id="view-text-material-title"></h2>
            <div id="view-text-material-content" class="text-material-display"></div>
            <button class="ok-btn" onclick="closeModal('view-text-material-modal')">Fechar</button>
        </div>
    </div>

    <script>
        // Funções para manipulação dos modais
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Função para visualizar material de texto
        function viewTextMaterial(title, content) {
            document.getElementById('view-text-material-title').textContent = title;
            document.getElementById('view-text-material-content').textContent = content;
            openModal('view-text-material-modal');
        }

        // Alternar entre tipo de material (arquivo/texto)
        document.getElementById('material-type-file').addEventListener('change', function() {
            document.getElementById('file-input-container').style.display = 'block';
            document.getElementById('text-input-container').style.display = 'none';
            document.getElementById('material-file').required = true;
            document.getElementById('material-text-content').required = false;
        });
        
        document.getElementById('material-type-text').addEventListener('change', function() {
            document.getElementById('file-input-container').style.display = 'none';
            document.getElementById('text-input-container').style.display = 'block';
            document.getElementById('material-file').required = false;
            document.getElementById('material-text-content').required = true;
        });

        // Event listener para o botão de adicionar material
        document.getElementById('add-material-btn').addEventListener('click', function() {
            openModal('add-material-modal');
        });

        // Fechar modal ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
    </script>
</body>
</html>