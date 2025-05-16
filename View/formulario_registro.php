<?php
session_start();

$errorData = [
    'error' => $_SESSION['error_registro'] ?? '',
    'campo_error' => $_SESSION['campo_error'] ?? ''
];
define('BASE_URL', 'http://localhost/ProyectoAula');
$formData = $_SESSION['form_data'] ?? [];
$mensajeExito = $_SESSION['mensaje_exito'] ?? '';
$redirectUrl = BASE_URL . '/View/login.php';

// Limpiar la sesión después de usar
unset($_SESSION['error_registro'], $_SESSION['form_data'], $_SESSION['campo_error'], $_SESSION['mensaje_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="../CSS/formulario.css">
    <link rel="stylesheet" href="../CSS/mensajeRegistro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.errorData = <?php echo json_encode($errorData); ?>;
        window.formData = <?php echo json_encode($formData); ?>;
        window.mensajeExito = <?php echo json_encode($mensajeExito); ?>;
        window.redirectUrl = <?php echo json_encode($redirectUrl); ?>;
    </script>
</head>
<body>
    <button class="back-button" onclick="window.history.back()">
        <i class="fas fa-arrow-left"></i>
        Volver
    </button>
    <div class="form-container">
            
        <form action="../Controller/usuarios/registrar_usuario.php" method="post" id="formRegistro">  
            <div class="form-group">
                <h3>Formulario de Registro</h3>
    
                <label for="cedula">Número de Documento:</label>
                <div id="mensaje-cedula" class="mensaje-error" style="display:none;"></div>
                <input type="text" id="cedula" name="cedula" required placeholder="Escriba cédula" 
                    pattern="[0-9]{7,11}" maxlength="11" 
                    value="<?= htmlspecialchars($formData['cedula'] ?? '') ?>"
                    class="<?= $campoError === 'cedula' ? 'campo-error' : '' ?>"><br><br>
    
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Escriba nombre completo" 
                    maxlength="100" value="<?= htmlspecialchars($formData['nombre'] ?? '') ?>"><br><br>
    
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="">Seleccione rol</option>
                    <option value="estudiante" <?= ($formData['rol'] ?? '') === 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
                    <option value="docente" <?= ($formData['rol'] ?? '') === 'docente' ? 'selected' : '' ?>>Docente</option>
                </select><br><br>
    
                <label for="institucion">Institución:</label>
                <select id="institucion" name="institucion" required>
                    <option value="">Seleccione institución</option>
                    <?php include __DIR__ . "/../Controller/usuarios/listar_instituciones.php"; ?>
                </select><br><br>
                
                <label for="email">Email:</label>
                <div id="mensaje-correo" class="mensaje-error" style="display:none;"></div>
                <input type="email" id="email" name="email" required placeholder="Escriba email" 
                    value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                    class="<?= $campoError === 'email' ? 'campo-error' : '' ?>"><br><br>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required 
                    placeholder="Escriba contraseña" minlength="6"><br><br>
    
                <label for="confirm_password">Confirmar contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Repita la contraseña" minlength="6"><br><br>
                
                <input type="submit" value="Registrar">
            </div>
        </form>
    </div>
    <script src="../JS/mensajeError.js"></script>
    <script src="../JS/verificarContraseña.js"></script>
</body>
</html>