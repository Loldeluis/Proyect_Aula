const languages = [
  {
    name: "HTML",
    color: "var(--html)",
    icon: "fab fa-html5",
    description:
      "Domina el lenguaje de la web, desde fundamentos hasta frameworks modernos.",
  },
  {
    name: "Python",
    color: "var(--python)",
    icon: "fab fa-python",
    description:
      "Aprende Python desde lo básico hasta temas avanzados como IA y ciencia de datos.",
  },
  {
    name: "Java",
    color: "var(--java)",
    icon: "fab fa-java",
    description:
      "Desarrolla aplicaciones robustas con este lenguaje orientado a objetos.",
  },
];

const container = document.getElementById("languages-container");

languages.forEach((lang) => {
  const langBox = document.createElement("div");
  langBox.className = `language-box ${lang.name.toLowerCase()}-box`;
  langBox.innerHTML = `
        <h3>
            <i class="${lang.icon}"></i>
            <span>${lang.name}</span>
        </h3>
        <p>${lang.description}</p>
        <div class="levels" id="levels-${lang.name}">
            <a href="#" class="level-btn" onclick="startLevel('${lang.name}', 1)">
                <i class="fas fa-star"></i> Nivel 1 - Básico
            </a>
            <a href="#" class="level-btn" onclick="startLevel('${lang.name}', 2)">
                <i class="fas fa-star-half-alt"></i> Nivel 2 - Intermedio
            </a>
            <a href="#" class="level-btn" onclick="startLevel('${lang.name}', 3)">
                <i class="fas fa-star"></i> Nivel 3 - Avanzado
            </a>
        </div>
    `;

  langBox.addEventListener("click", (e) => {
    if (!e.target.classList.contains("level-btn")) {
      document.querySelectorAll(".levels").forEach((level) => {
        level.style.display = "none";
      });
      const levels = langBox.querySelector(".levels");
      levels.style.display =
        levels.style.display === "block" ? "none" : "block";
    }
  });

  container.appendChild(langBox);
});

function startLevel(language, level) {
  const messages = [
    `¡Excelente elección! Preparando ${language} - Nivel ${level}...`,
    `Cargando contenido de ${language} para el nivel ${level}`,
    `Iniciando lecciones de ${language} - Nivel ${level}`,
  ];
  const randomMsg = messages[Math.floor(Math.random() * messages.length)];

  Swal.fire({
    title: "¡Comencemos!",
    text: randomMsg,
    icon: "success",
    confirmButtonText: "Continuar",
    confirmButtonColor: "var(--primary)",
    background: "white",
    backdrop: `
            rgba(67, 97, 238, 0.4)
            url("https://sweetalert2.github.io/images/nyan-cat.gif")
            center top
            no-repeat
        `,
    timer: 3000,
    didClose: () => {
      // Redirige después de mostrar la alerta
      const fileName = `${language.toLowerCase()}-curso${level}.php`;
      const path = `../View/${fileName}`;
      window.location.href = path;
    },
  });
}
