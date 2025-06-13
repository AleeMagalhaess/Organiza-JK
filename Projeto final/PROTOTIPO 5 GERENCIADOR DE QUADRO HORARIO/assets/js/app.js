document.addEventListener('DOMContentLoaded', function() {
    // Constantes
    const DEFAULT_TURMA = "150";
    const TURMAS = ["150", "250", "350", "351", "140", "240", "340", "341", "130", "230", "330", "120", "220", "320", "110", "210", "310"];
    
   const TURMAS_DATA = {
    "10": {
        courseName: "CURSO TÉCNICO EM ANÁLISES CLÍNICAS",
        subjects: [
            'AHFA', 'ARTE', 'BIOQUÍMICA', 'BIOLOGIA', 'BIOLOGIA CELULAR', 
            'COLETA - ÍMPAR', 'COLETA - PAR', 'EDUCAÇÃO FÍSICA', 'FILOSOFIA', 
            'FÍSICA', 'FUNDAMENTOS DE MICROCOSCOPIA', 'GEOGRAFIA', 
            'GESTÃO E EMPREENDEDORISMO', 'HEMATOLOGIA CLÍNICA', 'HISTÓRIA', 
            'IMUNOLOGIA CLÍNICA', 'INGLÊS', 'INGLÊS/ESPANHOL', 'LITERATURA', 
            'LÍNGUA PORTUGUESA', 'MATEMÁTICA', 'MICROBIOLOGIA', 
            'PARASITOLOGIA CLÍNICA', 'POE', 'PRÁTICA LABORATORIAL I - ÍMPAR', 
            'PRÁTICA LABORATORIAL I - PAR', 'PRÁTICA LABORATORIAL II BIO - ÍMPAR', 
            'PRÁTICA LABORATORIAL II BIO - PAR', 'PRÁTICA LABORATORIAL II MICRO - ÍMPAR', 
            'PRÁTICA LABORATORIAL II MICRO - PAR', 'PROJETO DE VIDA', 
            'PROJETO FINAL', 'QUÍMICA', 'RHEP', 'SAÚDE PÚBLICA', 'SMAS', 
            'SOCIOLOGIA', 'TI - ÍMPAR', 'TI - PAR', 'URINÁLISE - ÍMPAR', 
            'URINÁLISE - PAR'
        ].sort()
    },
    "20": {
        courseName: "CURSO TÉCNICO EM GUIA DE TURISMO",
        subjects: [
            'ARE', 'ARTE', 'BIOLOGIA', 'EDUCAÇÃO FÍSICA', 'ESPANHOL', 
            'FILOSOFIA', 'FÍSICA', 'FRANCÊS', 'FUNDAMENTOS DO TURISMO', 
            'GEO REGIONAL E NACIONAL', 'GEOGRAFIA', 'GESTÃO E EMPREENDEDORISMO', 
            'HISTÓRIA', 'HISTÓRIA DA ARTE REGIONAL E NACIONAL', 
            'HISTÓRIA REGIONAL E NACIONAL', 'HOTELARIA E ORGANIZAÇÃO DE EVENTOS', 
            'INGLÊS', 'LITERATURA', 'LÍNGUA PORTUGUESA', 'MATEMÁTICA', 
            'MTPST', 'POE', 'PRIMEIROS SOCORROS', 'PROJETO DE VIDA', 
            'PROJETO FINAL', 'PSICOLOGIA RH', 'QUÍMICA', 'RECREAÇÃO', 
            'SMAS', 'SOCIOLOGIA', 'TEORT', 'TI - ÍMPAR', 'TI - PAR', 
            'TMCP', 'TURISMO E SUSTENTABILIDADE', 'TÉCNICAS DE COMUNICAÇÃO', 
            'TÉCNICAS DE GUIAMENTO'
        ].sort()
    },
    "30": {
        courseName: "CURSO TÉCNICO EM ELETROTÉCNICA",
        subjects: [
            'ARTE', 'BIOLOGIA', 'DESENHO ASSISTIDO POR COMPUTADOR - ÍMPAR', 
            'DESENHO ASSISTIDO POR COMPUTADOR - PAR', 'DESENHO TÉCNICO', 
            'EDUCAÇÃO FÍSICA', 'ELETRICIDADE I', 'ELETRICIDADE II', 
            'ELETRÔNICA', 'FILOSOFIA', 'FÍSICA', 'FÍSICA APLICADA', 
            'GEOGRAFIA', 'GESTÃO EMPRESARIAL', 'HISTÓRIA', 'INGLÊS', 
            'INGLÊS/ESPANHOL', 'INSTALAÇÕES ELÉTRICAS', 'LABORATÓRIO I - ÍMPAR', 
            'LABORATÓRIO I - PAR', 'LABORATÓRIO II - ÍMPAR', 'LABORATÓRIO II - PAR', 
            'LABORATÓRIO III-ÍMPAR', 'LABORATÓRIO III-PAR', 'LITERATURA', 
            'LÍNGUA PORTUGUESA', 'MATEMÁTICA', 'MATEMÁTICA APLICADA', 
            'MÁQUINAS ELÉTRICAS', 'MÁQUINAS ELETRÔNICAS', 'POE', 
            'PROJETO DE VIDA', 'PROJETO FINAL', 'PSICOLOGIA RH', 
            'QUÍMICA', 'REDES ELÉTRICAS', 'SMAS', 'SOCIOLOGIA'
        ].sort()
    },
    "40": {
        courseName: "CURSO TÉCNICO EM ADMINISTRAÇÃO",
        subjects: [
            'ADMINISTRAÇÃO DE ORGANIZAÇÕES', 'ADMINISTRAÇÃO DE PESSOAS', 
            'ADMINISTRAÇÃO FINANCEIRA', 'ARTE', 'BIOLOGIA', 
            'CONTABILIDADE GERENCIAL', 'EDUCAÇÃO FÍSICA', 'ESPANHOL/INGLÊS', 
            'ESTATÍSTICA', 'FILOSOFIA', 'FÍSICA', 'FUNDAMENTOS DE ADMINISTRAÇÃO', 
            'FUNDAMENTOS DE CONTABILIDADE', 'FUNDAMENTOS DE DIREITO', 
            'FUNDAMENTOS DE ECONOMIA', 'GEOGRAFIA', 'GESTÃO AMBIENTAL', 
            'GESTÃO EMPRESARIAL', 'HISTÓRIA', 'INGLÊS', 'LITERATURA', 
            'LÍNGUA PORTUGUESA', 'MARKETING E VENDAS', 'MATEMÁTICA', 
            'MATEMÁTICA FINANCEIRA', 'POE', 'PRODUÇÃO E LOGÍSTICA', 
            'PROJETO DE VIDA', 'PSICOLOGIA RH', 'QUÍMICA', 'SMAS', 
            'SOCIOLOGIA', 'TI - ÍMPAR', 'TI - PAR', 'TI II - ÍMPAR', 
            'TI II - PAR', 'TI III - ÍMPAR', 'TI III - PAR'
        ].sort()
    },
    "50": {
        courseName: "CURSO TÉCNICO EM INFORMÁTICA",
        subjects: [
            'ARTE', 'ASCO - ÍMPAR', 'ASCO - PAR', 'BD I - ÍMPAR', 
            'BD I - PAR', 'BD II - ÍMPAR', 'BD II - PAR', 'BIOLOGIA', 
            'DG - ÍMPAR', 'DG - PAR', 'EDUCAÇÃO FÍSICA', 'FILOSOFIA', 
            'FÍSICA', 'FW I - ÍMPAR', 'FW I - PAR', 'FW II - ÍMPAR', 
            'FW II - PAR', 'GEOGRAFIA', 'GESTÃO EMPRESARIAL', 'HISTÓRIA', 
            'INGLÊS', 'LAI', 'LITERATURA', 'LP I - ÍMPAR', 'LP I - PAR', 
            'LP II - ÍMPAR', 'LP II - PAR', 'LP III - ÍMPAR', 'LP III - PAR', 
            'LÍNGUA PORTUGUESA', 'MATEMÁTICA', 'MD I - ÍMPAR', 'MD I - PAR', 
            'MD II - ÍMPAR', 'MD II - PAR', 'MM - ÍMPAR', 'MM - PAR', 
            'PDM - ÍMPAR', 'PDM - PAR', 'POE', 'PROJETO DE VIDA', 
            'PROJETO FINAL - ÍMPAR', 'PROJETO FINAL - PAR', 'PSICOLOGIA RH', 
            'QUÍMICA', 'RC - ÍMPAR', 'RC - PAR', 'SMAS', 'SOCIOLOGIA', 
            'TI - ÍMPAR', 'TI - PAR'
        ].sort()
    }
};

    const DAYS_FULL = ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];
    const DAYS_ABBR = { "Segunda": "Seg", "Terça": "Ter", "Quarta": "Qua", "Quinta": "Qui", "Sexta": "Sex", "Sábado": "Sab" };

    const SCHEDULABLE_TIMES_CONFIG = [
        { time: "07:00-08:40", id: "T1", applicableDays: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab"] },
        { time: "08:50-10:30", id: "T2", applicableDays: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab"] },
        { time: "10:30-12:00", id: "T3", applicableDays: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab"] },
        { time: "13:00-14:30", id: "T4", applicableDays: ["Seg", "Ter", "Qua", "Qui", "Sex"] },
        { time: "14:30-16:00", id: "T5", applicableDays: ["Seg", "Ter", "Qua", "Qui", "Sex"] },
        { time: "16:10-18:00", id: "T6", applicableDays: ["Seg", "Ter", "Qua", "Qui", "Sex"] }
    ];

    const DISPLAY_ROWS_CONFIG = [
        { time: "07:00-08:40", type: "class" },
        { time: "08:40-08:50", type: "break", label: "Intervalo" },
        { time: "08:50-10:30", type: "class" },
        { time: "10:30-12:00", type: "class" },
        { time: "12:00-13:00", type: "break", label: "Almoço", days: ["Seg", "Ter", "Qua", "Qui", "Sex"] },
        { time: "13:00-14:30", type: "class", days: ["Seg", "Ter", "Qua", "Qui", "Sex"] },
        { time: "14:30-16:00", type: "class", days: ["Seg", "Ter", "Qua", "Qui", "Sex"] },
        { time: "16:00-16:10", type: "break", label: "Intervalo", days: ["Seg", "Ter", "Qua", "Qui", "Sex"] },
        { time: "16:10-18:00", type: "class", days: ["Seg", "Ter", "Qua", "Qui", "Sex"] }
    ];

    // Estado
    let currentTurma = DEFAULT_TURMA;
    let teachersData = [];
    let schedule = {};
    let subjectToTeacherMap = {};
    let teacherScheduledSlots = {};

    // Elementos DOM
    const addTeacherForm = document.getElementById('add-teacher-form');
    const classSelector = document.getElementById('class-selector');
    const teacherNameInput = document.getElementById('teacher-name');
    const subjectInput = document.getElementById('subject');
    const subjectsDatalist = document.getElementById('subjects-datalist');
    const availableDaysContainer = document.getElementById('available-days-checkboxes');
    const availableTimesContainer = document.getElementById('available-times-checkboxes');
    const scheduleTableContainer = document.getElementById('schedule-table-container');
    const scheduleTitleHeader = document.getElementById('schedule-title-header');
    const downloadBtn = document.getElementById('download-schedule-btn');
    const errorMessageEl = document.getElementById('error-message');
    const successMessageEl = document.getElementById('success-message');

    // Inicialização
    function initializeApp() {
        populateClassSelector();
        populateDaysCheckboxes();
        populateTimesCheckboxes();
        setDefaultTurma();
        renderEmptySchedule();
    }

    function populateClassSelector() {
        TURMAS.forEach(turma => {
            const option = document.createElement('option');
            option.value = turma;
            option.textContent = turma;
            classSelector.appendChild(option);
        });
    }

    function populateDaysCheckboxes() {
        DAYS_FULL.forEach(day => {
            const div = document.createElement('div');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = `day-${DAYS_ABBR[day]}`;
            checkbox.name = 'available-days';
            checkbox.value = DAYS_ABBR[day];
            checkbox.addEventListener('change', updateAvailableTimesCheckboxes);
            
            const label = document.createElement('label');
            label.htmlFor = `day-${DAYS_ABBR[day]}`;
            label.textContent = day;
            
            div.appendChild(checkbox);
            div.appendChild(label);
            availableDaysContainer.appendChild(div);
        });
    }

    function populateTimesCheckboxes() {
        SCHEDULABLE_TIMES_CONFIG.forEach(slot => {
            const div = document.createElement('div');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = `time-${slot.id}`;
            checkbox.name = 'available-times';
            checkbox.value = slot.time;
            checkbox.dataset.timeId = slot.id;
            
            const label = document.createElement('label');
            label.htmlFor = `time-${slot.id}`;
            label.textContent = slot.time;
            
            div.appendChild(checkbox);
            div.appendChild(label);
            availableTimesContainer.appendChild(div);
        });
    }

    function setDefaultTurma() {
        classSelector.value = DEFAULT_TURMA;
        currentTurma = DEFAULT_TURMA;
        updateThemeAndSubjects();
    }

    function updateThemeAndSubjects() {
        const turmaValue = classSelector.value;
        currentTurma = turmaValue;
        
        // Resetar tema e matérias
        document.body.className = '';
        subjectsDatalist.innerHTML = '';
        
        if (!turmaValue) {
            subjectInput.placeholder = 'Selecione uma turma primeiro';
            subjectInput.disabled = true;
            return;
        }

        subjectInput.disabled = false;
        subjectInput.placeholder = 'Digite ou selecione uma matéria';

        const lastTwo = parseInt(turmaValue.slice(-2));
        const groupKey = (Math.floor(lastTwo / 10) * 10).toString();

        if (TURMAS_DATA[groupKey]) {
            document.body.className = `theme-${groupKey}`;
            scheduleTitleHeader.textContent = `${TURMAS_DATA[groupKey].courseName} - TURMA ${turmaValue}`;
            
            TURMAS_DATA[groupKey].subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject;
                subjectsDatalist.appendChild(option);
            });
        }
    }

    function renderEmptySchedule() {
        scheduleTableContainer.innerHTML = '';
        const table = document.createElement('table');
        
        // Cabeçalho
        const headerRow = table.insertRow();
        headerRow.appendChild(document.createElement('th')).textContent = 'Horário';
        DAYS_FULL.forEach(day => {
            headerRow.appendChild(document.createElement('th')).textContent = day;
        });

        // Linhas de horários
        DISPLAY_ROWS_CONFIG.forEach(row => {
            const tr = table.insertRow();
            tr.insertCell().outerHTML = `<td class="time-header">${row.time}</td>`;
            
            DAYS_FULL.forEach(day => {
                const dayAbbr = DAYS_ABBR[day];
                const td = tr.insertCell();
                
                if (row.type === 'break') {
                    const showBreak = !row.days || row.days.includes(dayAbbr);
                    td.className = showBreak ? 'break-slot' : 'empty-break-slot';
                    if (showBreak) td.textContent = row.label;
                } else {
                    td.className = 'class-slot';
                    if (row.days && !row.days.includes(dayAbbr)) {
                        td.classList.add('unavailable-slot');
                    }
                }
            });
        });

        scheduleTableContainer.appendChild(table);
    }

    function updateAvailableTimesCheckboxes() {
        const selectedDays = Array.from(
            availableDaysContainer.querySelectorAll('input[name="available-days"]:checked')
        ).map(cb => cb.value);

        availableTimesContainer.querySelectorAll('input[name="available-times"]').forEach(checkbox => {
            const timeId = checkbox.dataset.timeId;
            const timeConfig = SCHEDULABLE_TIMES_CONFIG.find(t => t.id === timeId);
            
            if (timeConfig) {
                const enabled = selectedDays.length === 0 || 
                               selectedDays.some(day => timeConfig.applicableDays.includes(day));
                checkbox.disabled = !enabled;
                if (!enabled) checkbox.checked = false;
            }
        });
    }

    function handleAddTeacher(event) {
        event.preventDefault();
        clearMessages();

        const formData = getTeacherDataFromForm();
        if (formData.error) {
            showMessage(errorMessageEl, formData.error, true);
            return;
        }

        const result = addTeacherToSchedule(formData.data);
        if (result.success) {
            renderSchedule();
            resetFormFields();
            showMessage(successMessageEl, result.message, false);
        } else {
            showMessage(errorMessageEl, result.message, true);
        }
    }

    function getTeacherDataFromForm() {
        if (!classSelector.value) {
            return { error: "Por favor, selecione uma turma." };
        }

        const teacherName = teacherNameInput.value.trim();
        const subject = subjectInput.value.trim();
        const selectedDays = Array.from(
            availableDaysContainer.querySelectorAll('input[name="available-days"]:checked')
        ).map(cb => cb.value);
        const selectedTimes = Array.from(
            availableTimesContainer.querySelectorAll('input[name="available-times"]:checked')
        ).map(cb => cb.value);

        if (!teacherName || !subject || selectedDays.length === 0 || selectedTimes.length === 0) {
            return { error: "Por favor, preencha todos os campos e selecione dias/horários." };
        }

        const availableSlots = [];
        selectedDays.forEach(day => {
            selectedTimes.forEach(time => {
                const timeConfig = SCHEDULABLE_TIMES_CONFIG.find(t => t.time === time);
                if (timeConfig && timeConfig.applicableDays.includes(day)) {
                    availableSlots.push(`${day}_${time}`);
                }
            });
        });

        if (availableSlots.length === 0) {
            return { error: "Nenhum horário válido selecionado para a combinação de dias e horários." };
        }

        return {
            data: {
                id: `teacher-${crypto.randomUUID()}`,
                name: teacherName,
                subject: subject,
                declaredAvailableSlots: availableSlots
            }
        };
    }

    function addTeacherToSchedule(teacher) {
        if (subjectToTeacherMap[teacher.subject]) {
            const existingTeacher = teachersData.find(t => t.id === subjectToTeacherMap[teacher.subject]);
            return {
                success: false,
                message: `A matéria '${teacher.subject}' já é lecionada por ${existingTeacher?.name || 'outro professor'}.`
            };
        }

        // Tentativa 1: Encontrar slot vazio
        for (const slot of teacher.declaredAvailableSlots) {
            if (!schedule[slot]) {
                schedule[slot] = {
                    teacherId: teacher.id,
                    teacherName: teacher.name,
                    subject: teacher.subject
                };
                teacherScheduledSlots[teacher.id] = slot;
                subjectToTeacherMap[teacher.subject] = teacher.id;
                teachersData.push(teacher);
                return {
                    success: true,
                    message: `Professor ${teacher.name} (${teacher.subject}) adicionado com sucesso!`
                };
            }
        }

        // Tentativa 2: Tentar realocar professores existentes
        for (const desiredSlot of teacher.declaredAvailableSlots) {
            const existingTeacher = schedule[desiredSlot];
            if (!existingTeacher) continue;

            const teacherData = teachersData.find(t => t.id === existingTeacher.teacherId);
            if (!teacherData) continue;

            for (const alternativeSlot of teacherData.declaredAvailableSlots) {
                if (alternativeSlot !== desiredSlot && !schedule[alternativeSlot]) {
                    // Move professor existente
                    schedule[alternativeSlot] = schedule[desiredSlot];
                    teacherScheduledSlots[teacherData.id] = alternativeSlot;
                    
                    // Adiciona novo professor
                    schedule[desiredSlot] = {
                        teacherId: teacher.id,
                        teacherName: teacher.name,
                        subject: teacher.subject
                    };
                    teacherScheduledSlots[teacher.id] = desiredSlot;
                    subjectToTeacherMap[teacher.subject] = teacher.id;
                    teachersData.push(teacher);
                    
                    return {
                        success: true,
                        message: `Professor ${teacher.name} adicionado! ${teacherData.name} foi realocado.`
                    };
                }
            }
        }

        return {
            success: false,
            message: `Não foi possível alocar horário para ${teacher.name}. Todos os horários estão ocupados.`
        };
    }

    function renderSchedule() {
        scheduleTableContainer.innerHTML = '';
        const table = document.createElement('table');
        
        // Cabeçalho
        const headerRow = table.insertRow();
        headerRow.appendChild(document.createElement('th')).textContent = 'Horário';
        DAYS_FULL.forEach(day => {
            headerRow.appendChild(document.createElement('th')).textContent = day;
        });

        // Linhas
        DISPLAY_ROWS_CONFIG.forEach(row => {
            const tr = table.insertRow();
            tr.insertCell().outerHTML = `<td class="time-header">${row.time}</td>`;
            
            DAYS_FULL.forEach(day => {
                const dayAbbr = DAYS_ABBR[day];
                const td = tr.insertCell();
                
                if (row.type === 'break') {
                    const showBreak = !row.days || row.days.includes(dayAbbr);
                    td.className = showBreak ? 'break-slot' : 'empty-break-slot';
                    if (showBreak) td.textContent = row.label;
                } else {
                    td.className = 'class-slot';
                    if (row.days && !row.days.includes(dayAbbr)) {
                        td.classList.add('unavailable-slot');
                    } else {
                        const slotId = `${dayAbbr}_${row.time}`;
                        const scheduledClass = schedule[slotId];
                        if (scheduledClass) {
                            td.classList.add('occupied');
                            td.innerHTML = `
                                <strong class="schedule-subject">${scheduledClass.subject}</strong>
                                <span class="schedule-teacher">${scheduledClass.teacherName}</span>
                            `;
                        }
                    }
                }
            });
        });

        scheduleTableContainer.appendChild(table);
    }

    function downloadScheduleAsImage() {
        const captureArea = document.getElementById('schedule-capture-area');
        if (!captureArea) {
            showMessage(errorMessageEl, "Área de captura não encontrada", true);
            return;
        }

        scheduleTitleHeader.style.display = 'block';
        const originalBg = document.body.style.backgroundColor;
        document.body.style.backgroundColor = '#ffffff';

        html2canvas(captureArea, {
            scale: 2,
            backgroundColor: '#ffffff',
            logging: false
        }).then(canvas => {
            scheduleTitleHeader.style.display = 'none';
            document.body.style.backgroundColor = originalBg;
            
            const link = document.createElement('a');
            link.download = `Horario_${currentTurma}_${new Date().toISOString().slice(0,10)}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        }).catch(err => {
            scheduleTitleHeader.style.display = 'none';
            document.body.style.backgroundColor = originalBg;
            console.error("Erro ao gerar imagem:", err);
            showMessage(errorMessageEl, "Erro ao gerar imagem da tabela", true);
        });
    }

    function resetFormFields() {
        teacherNameInput.value = '';
        subjectInput.value = '';
        availableDaysContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        availableTimesContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        updateAvailableTimesCheckboxes();
    }

    function clearMessages() {
        errorMessageEl.style.display = 'none';
        successMessageEl.style.display = 'none';
    }

    function showMessage(element, text, isError) {
        element.textContent = text;
        element.style.display = 'block';
        if (isError) {
            successMessageEl.style.display = 'none';
        } else {
            errorMessageEl.style.display = 'none';
        }
        setTimeout(() => element.style.display = 'none', 5000);
    }

    // Event Listeners
    addTeacherForm.addEventListener('submit', handleAddTeacher);
    classSelector.addEventListener('change', updateThemeAndSubjects);
    downloadBtn.addEventListener('click', downloadScheduleAsImage);

    // Inicializar aplicação
    initializeApp();
});