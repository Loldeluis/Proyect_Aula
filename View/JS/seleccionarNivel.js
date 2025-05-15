const languages = [
    { 
        name: "HTML", 
        color: "var(--html)",
        icon: "fab fa-html5",
        description: "Domina el lenguaje de la web, desde fundamentos hasta frameworks modernos."
    },
    { 
        name: "CSS", 
        color: "#264de4",
        icon: "fab fa-css3-alt",
        description: "Domina el lenguaje de la web, desde fundamentos hasta frameworks modernos."
    },
    { 
        name: "JavaScript", 
        color: "var(--javascript)",
        icon: "fab fa-js",
        description: "Domina el lenguaje de la web, desde fundamentos hasta frameworks modernos."
    },
    { 
        name: "Python", 
        color: "var(--python)",
        icon: "fab fa-python",
        description: "Aprende Python desde lo básico hasta temas avanzados como IA y ciencia de datos."
    },
    
    { 
        name: "Java", 
        color: "var(--java)",
        icon: "fab fa-java",
        description: "Desarrolla aplicaciones robustas con este lenguaje orientado a objetos."
    },
    { 
        name: "C++", 
        color: "var(--cpp)",
        icon: "fas fa-cogs",
        description: "Aprende programación de sistemas y desarrollo de alto rendimiento."
    }
];

const userProgress = {
    "HTML": 1,
    "CSS": 2,
    "JavaScript": 2,
    "Python": 1,
    "Java": 1,
    "C++": 0
};

const container = document.getElementById("languages-container");

languages.forEach(lang => {
    const langBox = document.createElement("div");
    langBox.className = `language-box ${lang.name.toLowerCase()}-box`;
    langBox.style.borderLeft = `8px solid ${lang.color}`;
    
    const progress = userProgress[lang.name] || 0;
    
    langBox.innerHTML = `
        <div class="lang-header">
            <i class="${lang.icon}"></i>
            <h3>${lang.name}</h3>
        </div>
        <p class="lang-description">${lang.description}</p>
        <div class="levels" id="levels-${lang.name}">
            <a href="#" class="level-btn ${progress >= 1 ? '' : 'current-level'}" 
            onclick="${progress >= 1 ? `startLevel('${lang.name}', 1)` : `checkAndStart('${lang.name}', 1)`}">
                <i class="fas fa-star"></i> Nivel 1 - Básico
            </a>
            <a href="#" class="level-btn ${progress >= 2 ? '' : 'locked-level'}" 
               onclick="${progress >= 2 ? `startLevel('${lang.name}', 2)` : `checkAndStart('${lang.name}', 2)`}">
                <i class="fas ${progress >= 2 ? 'fa-star-half-alt' : 'fa-lock'}"></i> Nivel 2 - Intermedio
            </a>
            <a href="#" class="level-btn ${progress >= 3 ? '' : 'locked-level'}" 
               onclick="${progress >= 3 ? `startLevel('${lang.name}', 3)` : `checkAndStart('${lang.name}', 3)`}">
                <i class="fas ${progress >= 3 ? 'fa-star' : 'fa-lock'}"></i> Nivel 3 - Avanzado
            </a>
        </div>
    `;
    
    langBox.addEventListener('click', (e) => {
        if (!e.target.classList.contains('level-btn') && !e.target.closest('.level-btn')) {
            document.querySelectorAll('.levels').forEach(level => {
                level.style.display = 'none';
            });
            const levels = langBox.querySelector('.levels');
            levels.style.display = levels.style.display === 'block' ? 'none' : 'block';
        }
    });
    
    container.appendChild(langBox);
});

function startLevel(language, level) {
    Swal.fire({
        title: `¡${language} - Nivel ${level}!`,
        text: `Preparando contenido educativo para ${language} nivel ${level}...`,
        icon: 'success',
        confirmButtonText: 'Continuar',
        confirmButtonColor: '#3085d6',
        timer: 3000
    });
}

function checkAndStart(language, level) {
    const progreso = userProgress[language] || 0;
    if (level > progreso) {
        Swal.fire({
            icon: 'warning',
            title: 'Nivel bloqueado',
            html: `
                <p>Debes completar el Nivel ${level - 1} antes de acceder al Nivel ${level}</p>
                <div style="margin-top: 15px; font-size: 0.9em; color: #666;">
                    <i class="fas fa-info-circle"></i> Tu progreso actual: Nivel ${progreso}
                </div>
            `,
            confirmButtonColor: '#3085d6'
        });
    } else {
        startLevel(language, level);
    }
}