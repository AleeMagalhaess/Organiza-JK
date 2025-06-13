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

// Alternar entre tipo de material (arquivo/texto) - usado na página de turma
if (document.getElementById('material-type-file') && document.getElementById('material-type-text')) {
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
}

// Função para visualizar material de texto
function viewTextMaterial(title, content) {
    document.getElementById('view-text-material-title').textContent = title;
    document.getElementById('view-text-material-content').textContent = content;
    openModal('view-text-material-modal');
}