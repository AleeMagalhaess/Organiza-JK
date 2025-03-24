document.getElementById('formCadastro').addEventListener('submit', function(event) {
    // Validação de senha
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    
    if (senha !== confirmarSenha) {
        alert('As senhas não coincidem!');
        event.preventDefault();
        return;
    }
    
    // Validação de telefone (opcional)
    const telefone = document.getElementById('telefone').value;
    if (telefone && !validarTelefone(telefone)) {
        alert('Por favor, insira um telefone válido no formato (00) 00000-0000');
        event.preventDefault();
        return;
    }
});

function validarTelefone(telefone) {
    const regex = /^\(\d{2}\) \d{5}-\d{4}$/;
    return regex.test(telefone);
}

// Máscara para telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length > 0) {
        value = '(' + value;
    }
    if (value.length > 3) {
        value = value.substring(0, 3) + ') ' + value.substring(3);
    }
    if (value.length > 10) {
        value = value.substring(0, 10) + '-' + value.substring(10, 14);
    }
    
    e.target.value = value;
});