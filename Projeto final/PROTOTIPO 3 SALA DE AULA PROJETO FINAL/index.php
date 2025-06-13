<?php
require_once 'config.php';
verificarLogin();

$conn = conectarDB();
$usuario_id = $_SESSION['usuario_id'];
$usuario_tipo = $_SESSION['usuario_tipo'];

// Obter turmas do usuário
if ($usuario_tipo === 'professor') {
    $stmt = $conn->prepare("SELECT * FROM turmas WHERE professor_id = ?");
} else {
    $stmt = $conn->prepare("SELECT t.* FROM turmas t JOIN usuario_turma ut ON t.id = ut.turma_id WHERE ut.usuario_id = ?");
}
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$turmas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Processar criação de turma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['criar_turma'])) {
    $nome = $_POST['nome'];
    $materia = $_POST['materia'];
    $codigo = gerarCodigoTurma();
    
    $stmt = $conn->prepare("INSERT INTO turmas (nome, materia, codigo_acesso, professor_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $materia, $codigo, $usuario_id);
    
    if ($stmt->execute()) {
        $mensagem_sucesso = "Turma criada com sucesso! Código: " . $codigo;
        // Atualizar lista de turmas
        $stmt = $conn->prepare("SELECT * FROM turmas WHERE professor_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $turmas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $erro = "Erro ao criar turma: " . $conn->error;
    }
}

// Processar entrada em turma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entrar_turma'])) {
    $codigo = strtoupper($_POST['codigo']);
    
    // Verificar se a turma existe
    $stmt = $conn->prepare("SELECT id FROM turmas WHERE codigo_acesso = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $turma = $result->fetch_assoc();
        $turma_id = $turma['id'];
        
        // Verificar se já está na turma
        $stmt = $conn->prepare("SELECT * FROM usuario_turma WHERE usuario_id = ? AND turma_id = ?");
        $stmt->bind_param("ii", $usuario_id, $turma_id);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows === 0) {
            // Matricular usuário
            $stmt = $conn->prepare("INSERT INTO usuario_turma (usuario_id, turma_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $usuario_id, $turma_id);
            
            if ($stmt->execute()) {
                $mensagem_sucesso = "Você entrou na turma com sucesso!";
                // Atualizar lista de turmas
                $stmt = $conn->prepare("SELECT t.* FROM turmas t JOIN usuario_turma ut ON t.id = ut.turma_id WHERE ut.usuario_id = ?");
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $turmas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            } else {
                $erro = "Erro ao entrar na turma: " . $conn->error;
            }
        } else {
            $erro = "Você já está nesta turma!";
        }
    } else {
        $erro = "Turma não encontrada com este código!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Turmas - Organiza JK</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><i class="fas fa-chalkboard-teacher"></i> Organiza JK</h1>
            <nav>
                <span class="user-info">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                <button id="join-class-btn" class="header-btn"><i class="fas fa-plus"></i> Entrar na Turma</button>
                <?php if ($_SESSION['usuario_tipo'] === 'professor'): ?>
                    <button id="create-class-btn" class="header-btn"><i class="fas fa-plus"></i> Criar Turma</button>
                <?php endif; ?>
                <a href="logout.php" class="header-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container" id="classroom-grid-container">
            <h2>Minhas Turmas</h2>
            
            <?php if (isset($mensagem_sucesso)): ?>
                <div class="success-message"><?php echo htmlspecialchars($mensagem_sucesso); ?></div>
            <?php endif; ?>
            
            <?php if (isset($erro)): ?>
                <div class="error-message"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            
            <div id="classroom-grid" class="classroom-grid">
                <?php if (empty($turmas)): ?>
                    <div class="classroom-card placeholder">
                        <div class="card-header" style="background-color: #e8f0fe; color: #5f6368;">
                            <h3>Nenhuma Turma Encontrada</h3>
                            <span></span>
                        </div>
                        <div class="card-body">
                            <p>
                                <?php if ($_SESSION['usuario_tipo'] === 'professor'): ?>
                                    Crie uma nova turma usando o botão "+" no canto superior direito.
                                <?php else: ?>
                                    Entre em uma turma usando o código fornecido pelo seu professor.
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="card-footer" style="justify-content: center;">
                            <span><i class="fas fa-info-circle"></i> Use os botões "+" para começar</span>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($turmas as $turma): ?>
                        <div class="classroom-card" onclick="window.location.href='turma.php?id=<?php echo $turma['id']; ?>'">
                            <div class="card-header">
                                <h3><?php echo htmlspecialchars($turma['nome']); ?></h3>
                                <span><?php echo htmlspecialchars($turma['materia'] ? $turma['materia'] . ' - ' : ''); ?>Turma</span>
                            </div>
                            <div class="card-body">
                                <p>Acesse para ver os materiais e atividades.</p>
                                <?php
                                // Contar materiais da turma
                                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM materiais WHERE turma_id = ?");
                                $stmt->bind_param("i", $turma['id']);
                                $stmt->execute();
                                $total_materiais = $stmt->get_result()->fetch_assoc()['total'];
                                ?>
                                <p><small><?php echo $total_materiais; ?> material(is) disponível(eis).</small></p>
                            </div>
                            <div class="card-footer">
                                <span>Código: <?php echo htmlspecialchars($turma['codigo_acesso']); ?></span>
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Modal Criar Turma -->
    <div id="create-class-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('create-class-modal')">&times;</span>
            <h2>Criar Nova Turma</h2>
            <form id="create-class-form" method="POST">
                <input type="hidden" name="criar_turma" value="1">
                <label for="class-name">Nome da Turma:</label>
                <input type="text" id="class-name" name="nome" required>

                <label for="class-subject">Matéria (Opcional):</label>
                <input type="text" id="class-subject" name="materia">

                <label for="class-teacher">Professor:</label>
                <input type="text" id="class-teacher" name="professor" value="<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>" readonly required>

                <button type="submit">Criar</button>
            </form>
        </div>
    </div>

    <!-- Modal Entrar na Turma -->
    <div id="join-class-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('join-class-modal')">&times;</span>
            <h2>Entrar na Turma</h2>
            <form id="join-class-form" method="POST">
                <input type="hidden" name="entrar_turma" value="1">
                <label for="join-code">Código da Turma:</label>
                <input type="text" id="join-code" name="codigo" placeholder="Digite o código" required>
                <button type="submit">Entrar</button>
                <p class="info">Peça o código da turma ao seu professor e digite-o aqui.</p>
            </form>
        </div>
    </div>

    <!-- Modal de Sucesso -->
    <div id="success-modal" class="modal">
        <div class="modal-content success-content">
            <span class="close-btn" onclick="closeModal('success-modal')">&times;</span>
            <h2><i class="fas fa-check-circle"></i> Sucesso!</h2>
            <p id="success-message-text"></p>
            <p id="success-class-code" class="info"></p> 
            <button class="ok-btn" onclick="closeModal('success-modal')">OK</button>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // Funções para manipulação dos modais
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Event listeners para abrir modais
        document.getElementById('create-class-btn')?.addEventListener('click', () => openModal('create-class-modal'));
        document.getElementById('join-class-btn')?.addEventListener('click', () => openModal('join-class-modal'));

        // Fechar modal ao clicar fora
        window.addEventListener('click', (event) => {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });

        // Exibir mensagem de sucesso se houver
        <?php if (isset($mensagem_sucesso)): ?>
            document.getElementById('success-message-text').textContent = '<?php echo addslashes($mensagem_sucesso); ?>';
            openModal('success-modal');
        <?php endif; ?>
    </script>
</body>
</html>