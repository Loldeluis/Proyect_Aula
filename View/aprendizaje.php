<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}

$nombre_estudiante = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aprende Programación</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
    <i class="fas fa-laptop-code"></i>
    <span>Bienvenido estudiante: <?php echo $_SESSION['nombre_usuario']; ?></span>
    </header>

    <div class="container">
        <h2>Selecciona un lenguaje de programación</h2>
        <p class="welcome-message">Elige un lenguaje y nivel para comenzar tu aprendizaje</p>
        <div class="grid" id="languages-container"></div>

        <button class="btn-back" onclick="window.location.href='Principal.php'">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </button>

        <button class="btn" onclick="window.location.href='ver_desafios.php'">
        <i class="fas fa-tasks"></i> Ver Desafíos Asignados
    </button>

    </div>
    <div class="language-box" style="border-left: 8px solid #20c997;">
    <h3>Inscribirse a Curso</h3>
    <p>Explora cursos disponibles y únete para comenzar a aprender.</p>
    <button class="btn" onclick="location.href='inscribirse_curso.php'">Ver Cursos</button>
</div>

    <script>
        const languages = [
            { name: "Python", color: "#4B8BBE" },
            { name: "JavaScript", color: "#F7DF1E" },
            { name: "Java", color: "#F89820" },
            { name: "C++", color: "#00599C" }
        ];

        const userProgress = {
            "Python": 1,
            "JavaScript": 2,
            "Java": 1,
            "C++": 0
        };

        const container = document.getElementById("languages-container");

        languages.forEach(lang => {
            const langBox = document.createElement("div");
            langBox.className = "language-box";
            langBox.style.borderLeft = `8px solid ${lang.color}`;
            langBox.innerHTML = `
                <h3>${lang.name}</h3>
                <p>Selecciona un nivel para comenzar:</p>
                <div class="levels" id="levels-${lang.name}">
                    <button class="btn" onclick="startLevel('${lang.name}', 1)">Nivel 1</button>
                    <button class="btn" onclick="checkAndStart('${lang.name}', 2)">Nivel 2</button>
                    <button class="btn" onclick="checkAndStart('${lang.name}', 3)">Nivel 3</button>
                </div>
            `;

            langBox.onclick = () => {
                document.querySelectorAll('.levels').forEach(level => level.style.display = 'none');
                document.getElementById(`levels-${lang.name}`).style.display = 'block';
            };

            container.appendChild(langBox);
        });

        function startLevel(language, level) {
            window.location.href = `nivel.php?lenguaje=${language}&nivel=${level}`;
        }

        function checkAndStart(language, level) {
            const progreso = userProgress[language] || 0;
            if (level > progreso) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nivel bloqueado',
                    text: `Debes completar el Nivel ${level - 1} antes de acceder al Nivel ${level}`,
                    confirmButtonColor: '#3085d6'
                });
            } else {
                startLevel(language, level);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
