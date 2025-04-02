const languages = [
    { name: "Python", color: "#3776AB" },
    { name: "JavaScript", color: "#F7DF1E" },
    { name: "Java", color: "#F89820" },
    { name: "C++", color: "#00599C" }
];

const container = document.getElementById("languages-container");

languages.forEach(lang => {
    const langBox = document.createElement("div");
    langBox.className = "language-box";
    langBox.style.borderLeft = `5px solid ${lang.color}`;
    langBox.innerHTML = `
        <h3>${lang.name}</h3>
        <p>Selecciona un nivel para comenzar.</p>
        <div class="levels" id="levels-${lang.name}">
            <button class="btn" onclick="startLevel('${lang.name}', 1)">Nivel 1</button>
            <button class="btn" onclick="startLevel('${lang.name}', 2)">Nivel 2</button>
            <button class="btn" onclick="startLevel('${lang.name}', 3)">Nivel 3</button>
        </div>
    `;
    langBox.onclick = () => {
        document.querySelectorAll('.levels').forEach(level => level.style.display = 'none');
        document.getElementById(`levels-${lang.name}`).style.display = 'block';
    };
    container.appendChild(langBox);
});

function startLevel(language, level) {
    alert(`Iniciando ${language} - Nivel ${level}`);
}

function goBack() {
window.location.href = "index.html"; 
}