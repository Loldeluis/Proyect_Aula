
const languages = [
    {
        name: "HTML (HyperText Markup Language)",
        description: "Es el lenguaje estándar para crear páginas web. Define la estructura y el contenido de una página mediante el uso de elementos y etiquetas.",
        color: "#E44D26",
        link: "https://developer.mozilla.org/es/docs/Web/HTML",
        icon: "fab fa-html5",
        features: [
            "Lenguaje de marcado para estructurar contenido web",
            "Utiliza un sistema de etiquetas anidadas",
            "Base fundamental de todas las páginas web",
            "Se complementa con CSS y JavaScript",
            "Versiones HTML5 (actual) con semántica mejorada"
        ]
    },
    {
        name: "CSS (Cascading Style Sheets)",
        description: "Es el lenguaje usado para describir la presentación de documentos HTML. Controla el diseño, colores, fuentes y otros aspectos visuales de una página web.",
        color: "#264de4",
        link: "https://developer.mozilla.org/es/docs/Web/CSS",
        icon: "fab fa-css3-alt",
        features: [
            "Separa el contenido (HTML) de su presentación",
            "Sistema de selectores para aplicar estilos",
            "Modelo de caja para diseño",
            "Flexbox y Grid para layouts modernos",
            "Animaciones y transiciones"
        ]
    },
    {
        name: "JavaScript",
        description: "El lenguaje fundamental para desarrollo web frontend y backend con Node.js.",
        color: "#F7DF1E",
        link: "https://developer.mozilla.org/es/docs/Web/JavaScript",
        icon: "fab fa-js",
        features: [
            "Lenguaje interpretado del lado del cliente",
            "Orientado a objetos basado en prototipos",
            "Asíncrono y no bloqueante",
            "Ecosistema con frameworks como React, Angular, Vue",
            "Node.js para ejecución en servidor"
        ]
    },
    {
        name: "Python",
        description: "El lenguaje ideal para inteligencia artificial, ciencia de datos y desarrollo rápido de aplicaciones.",
        color: "#3776AB",
        link: "https://www.python.org/",
        icon: "fab fa-python",
        features: [
            "Sintaxis simple y fácil de aprender",
            "Tipado dinámico y multiparadigma",
            "Amplia biblioteca estándar",
            "Frameworks como Django y Flask para web",
            "Popular en ciencia de datos (Pandas, NumPy)"
        ]
    },
    {
        name: "Java",
        description: "El lenguaje robusto para aplicaciones empresariales, Android y sistemas distribuidos.",
        color: "#F89820",
        link: "https://www.java.com/es/",
        icon: "fab fa-java",
        features: [
            "Orientado a objetos puro",
            "Compilado a bytecode (JVM)",
            "Gran ecosistema empresarial",
            "Lenguaje principal para Android",
            "Manejo automático de memoria (GC)"
        ]
    },
    {
        name: "C++",
        description: "El lenguaje de alto rendimiento para juegos, sistemas embebidos y aplicaciones críticas.",
        color: "#00599C",
        link: "https://cplusplus.com/",
        icon: "fas fa-cogs",
        features: [
            "Extensión de C con orientación a objetos",
            "Control granular de memoria",
            "Alto rendimiento y eficiencia",
            "Usado en motores de juego (Unreal)",
            "Sistemas operativos y drivers"
        ]
    }
];
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("languages-container");
    
    languages.forEach((lang) => {
        const langBox = document.createElement("div");
        langBox.className = "language-box";
        langBox.style.borderLeftColor = lang.color;
        langBox.innerHTML = `
            <h3 style="color: ${lang.color}">
                <i class="${lang.icon}"></i>
                <span>${lang.name}</span>
            </h3>
            <p>${lang.description}</p>
            <a href="${lang.link}" class="btn" target="_blank" style="background: ${lang.color}; align-self: flex-start; margin-top: auto;">
                <i class="fas fa-external-link-alt"></i>
                <span>Explorar</span>
            </a>
        `;
        container.appendChild(langBox);
    });
});

function openModal(id) {
    document.getElementById(id).style.display = "flex";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

function showSection(sectionId) {
    // Oculta todas las secciones
    document.querySelectorAll(".container").forEach((el) => {
        el.style.display = "none";
    });

    // Muestra la sección seleccionada
    document.getElementById(sectionId).style.display = "block";
    

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}
