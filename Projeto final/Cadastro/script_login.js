document.getElementById('formLogin').addEventListener('submit', function(event) {
    // Validações básicas podem ser adicionadas aqui
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;
    
    if (!email || !senha) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        event.preventDefault();
    }
});