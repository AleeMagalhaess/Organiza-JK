// Add event listeners or further functionality here if needed in the future.
// For example:
const coordButton = document.getElementById('coordButton');
const alunoButton = document.getElementById('alunoButton');

coordButton.addEventListener('click', () => {
    console.log('Modo Coordenação selecionado');
    // Navigate to the local coordination page
    window.location.href = '../Prototipo 2 Boletim/login_admin.php'; // Changed to local HTML page
});

alunoButton.addEventListener('click', () => {
    console.log('Modo Aluno selecionado');
    // Navigate to the local student page
    window.location.href = '../Prototipo 2 Boletim/login.php'; // Changed to local HTML page
});