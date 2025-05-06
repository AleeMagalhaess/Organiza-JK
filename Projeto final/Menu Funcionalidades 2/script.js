

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.feature-card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            
            const featureTitle = card.querySelector('h3').textContent;
            let targetUrl = '#'; 

          
            if (featureTitle.includes('Sala de aula')) {
                targetUrl = '../Prototipo 2 Sala de Aula/saladeaula.html';
            } else if (featureTitle.includes('Boletim escolar')) {
                targetUrl = '../teste menunovo boletim/index.html'; 
            } else if (featureTitle.includes('Gerador de Horários')) {
                targetUrl = '../Horarios/prototipo2.html'; 
            }

            console.log(`Navigating to ${targetUrl}...`);
            window.location.href = targetUrl; // Navigate to the determined URL
        });
    });
});