const createClassBtn = document.getElementById('create-class-btn');
const joinClassBtn = document.getElementById('join-class-btn');
const createClassModal = document.getElementById('create-class-modal');
const joinClassModal = document.getElementById('join-class-modal');
const successModal = document.getElementById('success-modal'); // Get success modal
const successClassCodeElement = document.getElementById('success-class-code'); // Get element to display code
const createClassForm = document.getElementById('create-class-form');
const joinClassForm = document.getElementById('join-class-form');
const classroomGrid = document.getElementById('classroom-grid');

// Function to open modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

// Function to close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Generate random alphanumeric code (e.g., 6 characters)
function generateClassCode(length = 6) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}

// Add new classroom card to the grid
function addClassroomCard(name, subject, teacher, code) {
    // Remove placeholder if it exists
    const placeholder = classroomGrid.querySelector('.placeholder');
    if (placeholder) {
        placeholder.remove();
    }

    const card = document.createElement('div');
    card.classList.add('classroom-card');

    card.innerHTML = `
        <div class="card-header">
            <h3>${name}</h3>
            <span>${subject ? subject + ' - ' : ''}${teacher}</span>
        </div>
        <div class="card-body">
            <p>Bem-vindo à turma!</p>
            <!-- Future content like assignments -->
        </div>
        <div class="card-footer">
           <span>Código: ${code}</span>
           <!-- Add icons/links later -->
           <i class="fas fa-ellipsis-v"></i>
        </div>
    `;
    classroomGrid.appendChild(card);
}

// --- Event Listeners ---

// Open Modals
createClassBtn.addEventListener('click', () => openModal('create-class-modal'));
joinClassBtn.addEventListener('click', () => openModal('join-class-modal'));

// Close Modals via clicks outside the modal content
window.addEventListener('click', (event) => {
    if (event.target == createClassModal) {
        closeModal('create-class-modal');
    }
    if (event.target == joinClassModal) {
        closeModal('join-class-modal');
    }
    if (event.target == successModal) { // Add listener for success modal
        closeModal('success-modal');
    }
});

// Handle Create Class Form Submission
createClassForm.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent actual form submission
    const className = document.getElementById('class-name').value;
    const classSubject = document.getElementById('class-subject').value;
    const classTeacher = document.getElementById('class-teacher').value;
    const classCode = generateClassCode();

    // Add the new class card to the UI
    addClassroomCard(className, classSubject, classTeacher, classCode);

    // Close the create modal FIRST
    closeModal('create-class-modal');

    // Set the class code in the success modal
    successClassCodeElement.textContent = `Código de acesso: ${classCode}`;

    // Open the success modal
    openModal('success-modal');

    // Reset form after modals are handled
    createClassForm.reset();

    // In a real application, you would send this data to the server (PHP)
    // to save it in the database.
    console.log(`Class Created (Simulated): Name: ${className}, Subject: ${classSubject}, Teacher: ${classTeacher}, Code: ${classCode}`);
});

// Handle Join Class Form Submission (Simulation)
joinClassForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const joinCode = document.getElementById('join-code').value;

    // In a real app, send the code to the server to validate and join the class.
    // Here, we just show an alert.
    alert(`Tentativa de entrar na turma com o código: ${joinCode}\n(Funcionalidade de backend necessária)`);

    joinClassForm.reset();
    closeModal('join-class-modal');
});

// Add initial placeholder if grid is empty
if (classroomGrid.children.length === 0) {
     const placeholderCard = document.createElement('div');
     placeholderCard.classList.add('classroom-card', 'placeholder');
     placeholderCard.innerHTML = `
        <div class="card-header" style="background-color: #e8f0fe; color: #5f6368;">
            <h3>Nenhuma Turma</h3>
             <span></span>
        </div>
        <div class="card-body">
             <p>Crie ou entre em uma turma usando os botões no canto superior direito.</p>
        </div>
        <div class="card-footer" style="justify-content: center;">
             <span><i class="fas fa-info-circle"></i> Use "+" para começar</span>
        </div>
    `;
     classroomGrid.appendChild(placeholderCard);
}