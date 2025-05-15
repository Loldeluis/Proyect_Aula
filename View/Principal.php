<?php
session_start();
if (isset($_SESSION['nombre_usuario'])) {
    $usuario = $_SESSION['nombre_usuario'];
} else {
    $usuario = null;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aprende Programación</title>
     <link rel="stylesheet" href="css/principal.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="logo">
      <i class="fas fa-code"></i>
      <span>Aprende Programación</span>
    </div>

    <div class="auth-buttons">
      <?php if ($usuario): ?>
        <span style="color: white; margin-right: 10px;">
          👋 Hola, <?php echo htmlspecialchars($usuario); ?>
        </span>
        <a href="../Controller/Peticiones/logout.php" class="auth-btn logout-btn">
          <i class="fas fa-sign-out-alt"></i>
          <span>Cerrar sesión</span>
        </a>
      <?php else: ?>
        <a href="login.html" class="auth-btn login-btn">
          <i class="fas fa-sign-in-alt"></i>
          <span>Iniciar sesión</span>
        </a>
        <a href="formulario_registro.php" class="auth-btn register-btn">
          <i class="fas fa-user-plus"></i>
          <span>Registrarse</span>
        </a>
      <?php endif; ?>
    </div>
  </header>

  <nav>
      <a href="#" onclick="showSection('inicio')">
        <i class="fas fa-home"></i>
          <span>Inicio</span>
      </a>
      <a href="#" onclick="showSection('lenguajes')">
          <i class="fas fa-laptop-code"></i>
          <span>Lenguajes</span>
      </a>
      <a href="#" onclick="showSection('recursos')">
          <i class="fas fa-book"></i>
          <span>Recursos</span>
      </a>
      <a href="#" onclick="openModal('contactModal')">
          <i class="fas fa-envelope"></i>
          <span>Contacto</span>
      </a>
  </nav>

  <!-- Sección de Inicio -->
  <div id="inicio" class="container">
      <div class="hero">
          <h1>Domina el Arte de la Programación</h1>
          <p>Sumérgete en el mundo del desarrollo de software y adquiere las habilidades más demandadas de la industria tecnológica.</p>
          <img
              src="img/2023-03-09-Quantas-linguagens-de-programacao-existem.jpg"
              alt="Lenguajes de programación"
              class="hero-img"
          />
          <br />
          <a href="../View/Panel_estudiante/aprendizaje.php" class="btn">
              <i class="fas fa-rocket"></i>
              <span>Comenzar ahora</span>
          </a>
      </div>
  </div>

  <div id="recursos" class="container" style="display: none">
      <div class="section-title">
          <h2>Recursos de Aprendizaje</h2>
      </div>
      <p class="text-center" style="max-width: 800px; margin: 0 auto 2rem;">Descubre las mejores herramientas y plataformas para acelerar tu aprendizaje en programación.</p>

      <div class="grid">
          <div class="card">
              <i class="fas fa-file-alt" style="font-size: 2.5rem; color: var(--accent); margin-bottom: 1rem;"></i>
              <h3>Documentación Oficial</h3>
              <p>Accede a las fuentes más confiables y actualizadas de cada tecnología.</p>
              <a
                  href="https://developer.mozilla.org/es/"
                  class="btn btn-outline"
                  target="_blank"
              >
                  <i class="fab fa-firefox"></i>
                  <span>MDN Web Docs</span>
              </a>
          </div>
          <div class="card">
              <i class="fas fa-graduation-cap" style="font-size: 2.5rem; color: var(--accent); margin-bottom: 1rem;"></i>
              <h3>Cursos Interactivos</h3>
              <p>Aprende con proyectos prácticos y ejercicios en tiempo real.</p>
              <a href="https://www.freecodecamp.org/" class="btn btn-outline" target="_blank">
                  <i class="fab fa-free-code-camp"></i>
                  <span>FreeCodeCamp</span>
              </a>
          </div>
          <div class="card">
              <i class="fas fa-code" style="font-size: 2.5rem; color: var(--accent); margin-bottom: 1rem;"></i>
              <h3>Entornos de Práctica</h3>
              <p>Ejecuta código directamente desde tu navegador sin configuraciones complejas.</p>
              <a href="https://replit.com/" class="btn btn-outline" target="_blank">
                  <i class="fas fa-terminal"></i>
                  <span>Replit</span>
              </a>
          </div>
      </div>
  </div>

  <div id="lenguajes" class="container" style="display: none">
      <div class="section-title">
          <h2>Lenguajes de Programación</h2>
      </div>
      <p class="text-center" style="max-width: 800px; margin: 0 auto 2rem;">Explora los lenguajes más populares y encuentra el ideal para tus objetivos.</p>
      <div class="grid" id="languages-container">
          <!-- Los lenguajes se cargarán aquí dinámicamente -->
      </div>
  </div>

  <!-- Modal de Contacto -->
  <div id="contactModal" class="modal">
      <div class="modal-content">
          <span class="close" onclick="closeModal('contactModal')">&times;</span>
          <h3 style="text-align: center; margin-bottom: 1.5rem; color: var(--primary);">Contáctanos</h3>
          <div style="text-align: center; margin-bottom: 1.5rem;">
              <i class="fas fa-phone-alt" style="color: var(--accent); font-size: 1.5rem; margin-bottom: 1rem;"></i>
              <p style="font-size: 1.2rem;"><strong>Teléfono:</strong> +57 300 123 4567</p>
          </div>
          <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1.5rem;">
              <a href="https://wa.me/573001234567" target="_blank" class="btn" style="background-color: #25D366;">
                  <i class="fab fa-whatsapp"></i>
                  <span>WhatsApp</span>
              </a>
              <a href="mailto:contacto@aprendeprogramacion.com" class="btn" style="background-color: #EA4335;">
                  <i class="fas fa-envelope"></i>
                  <span>Email</span>
              </a>
          </div>
      </div>
  </div>
  
  <footer>
      <p>© 2023 Aprende Programación. Todos los derechos reservados.</p>
      <div style="margin-top: 1rem; display: flex; justify-content: center; gap: 1.5rem;">
          <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
          <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-twitter"></i></a>
          <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
          <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-github"></i></a>
      </div>
  </footer>
  <script src="/JS/app.js" crossorigin="anonymous"></script>
  </body>
</html>
