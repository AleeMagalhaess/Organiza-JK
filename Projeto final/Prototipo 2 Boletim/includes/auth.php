<?php
function verificarAdmin() {
    if (!isset($_SESSION['admin_logado'])) {
        header('Location: ../login_admin.php');
        exit();
    }
}

function verificarAluno() {
    if (!isset($_SESSION['aluno_id'])) {
        header('Location: ../login.php');
        exit();
    }
}
?>