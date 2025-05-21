<?php
define('BASE_DIR', dirname(__DIR__));
require_once(BASE_DIR . '/Model/entity/Conexion.php');
require_once(BASE_DIR . '/Model/crud/Usuario_crud.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$crud = new Usuario_crud();
$usuario = $crud->obtenerUsuarioPorId($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <button class="back-button" onclick="window.history.back()">
        <i class="fas fa-arrow-left"></i> Volver </button>

    
    <div class="profile-container">
        <div class="profile-card">
            <h1>Perfil de Usuario</h1>
            
            <form action="../Controller/usuarios/actualizar_perfil.php" method="POST">
                <div class="form-group">
                    <label for="cedula">Número de Documento:</label>
                    <input type="text" id="cedula" name="cedula" disabled 
                        value="<?= htmlspecialchars($usuario['cedula']) ?>">
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required 
                        maxlength="100" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>">
                </div>

                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <input type="text" id="rol" name="rol" disabled 
                        value="<?= ucfirst(htmlspecialchars($usuario['rol'])) ?>">
                </div>

                <div class="form-group">
                    <label for="institucion">Institución:</label>
                    <input type="text" id="institucion" name="institucion" disabled 
                        value="<?= htmlspecialchars($usuario['institucion']) ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required 
                        value="<?= htmlspecialchars($usuario['correo']) ?>">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Actualizar Perfil
                    </button>
                    
                    <div class="secondary-actions">
                        <button type="button" id="btn-cambiar-contrasena" class="btn-action" onclick="abrirModal()">
                            <i class="fas fa-key"></i> Cambiar contraseña
                        </button>
                        
                        <button type="button" id="btn-eliminar-cuenta" class="btn-action btn-danger" onclick="pedirContrasena()">
                            <i class="fas fa-trash-alt"></i> Eliminar cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="modalPassword" class="modal" style="display:none;">
        <div class="modal-contenido">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h3>Cambiar Contraseña</h3>
            <form id="formPassword" action="../Controller/usuarios/actualizar_contraseña.php" method="POST">
                <div class="form-group">
                    <label for="actual">Contraseña actual:</label>
                    <input type="password" name="actual" required>
                </div>
                
                <div class="form-group">
                    <label for="nueva">Nueva contraseña:</label>
                    <input type="password" name="nueva" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirmar">Confirmar nueva contraseña:</label>
                    <input type="password" name="confirmar" required minlength="6">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn-confirm">Actualizar contraseña</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../JS/abrirCerrarModal.js"></script>
    <script src="../JS/confirmarEliminacion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_GET['exito'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'Perfil actualizado correctamente',
            confirmButtonColor: '#3f37c9'
        });
    </script>
<?php elseif (isset($_GET['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Datos inválidos. Verifica los campos.',
            confirmButtonColor: '#f72585'
        });
    </script>
<?php endif; ?>
</body>
</html>