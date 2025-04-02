const languages = [
    {
      name: "Python",
      description: "Ideal para inteligencia artificial y ciencia de datos.",
      color: "#3776AB",
      link: "https://www.python.org/",
    },
    {
      name: "JavaScript",
      description: "El alma del desarrollo web dinámico e interactivo.",
      color: "#F7DF1E",
      link: "https://developer.mozilla.org/es/docs/Web/JavaScript",
    },
    {
      name: "Java",
      description:
        "Lenguaje versátil para aplicaciones empresariales y móviles.",
      color: "#F89820",
      link: "https://www.java.com/es/",
    },
    {
      name: "C++",
      description:
        "Potente y rápido, usado en juegos y sistemas embebidos.",
      color: "#00599C",
      link: "https://cplusplus.com/",
    },
  ];

  const container = document.getElementById("languages-container");

  languages.forEach((lang) => {
    const langBox = document.createElement("div");
    langBox.className = "language-box";
    langBox.style.borderLeft = `5px solid ${lang.color}`;
    langBox.innerHTML = `
        <h3>${lang.name}</h3>
        <p>${lang.description}</p>
        <a href="${lang.link}" class="btn" target="_blank">Explorar</a>
    `;
    container.appendChild(langBox);
  });

  function openModal(id) {
    document.getElementById(id).style.display = "flex";
  }

  function closeModal(id) {
    document.getElementById(id).style.display = "none";
  }
  function showSection(sectionId) {
    // Oculta todas las secciones antes de mostrar la nueva
    document
      .querySelectorAll(".container")
      .forEach((el) => (el.style.display = "none"));

    // Muestra la sección seleccionada
    document.getElementById(sectionId).style.display = "block";
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginModal").style.display = "none";
    document.getElementById("registerModal").style.display = "none";
    document.getElementById("contactModal").style.display = "none";
  });