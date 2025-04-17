// script.js - No changes needed for visual enhancements, keeping existing functionality.

document.addEventListener('DOMContentLoaded', () => {
    const signupButton = document.getElementById('signup-btn');
    const loginButton = document.getElementById('login-btn');

    if (signupButton) {
        signupButton.addEventListener('click', () => {
            console.log('Botão Cadastrar clicado!');
            // Logic for signup (e.g., open modal) can be added here.
            // alert('Funcionalidade de Cadastro ainda não implementada.');
        });
    }

    if (loginButton) {
        loginButton.addEventListener('click', () => {
            console.log('Botão Login clicado!');
            // Logic for login can be added here.
            // alert('Funcionalidade de Login ainda não implementada.');
        });
    }

    // Optional: Add smooth scrolling for anchor links if needed later
    // document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    //     anchor.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         document.querySelector(this.getAttribute('href')).scrollIntoView({
    //             behavior: 'smooth'
    //         });
    //     });
    // });
});