<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="../CSS/formulario.css">
    <link rel="stylesheet" href="../CSS/mensajeRegistro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body>
<a href="../View/Principal.html" class="back-button">Inicio</a>
            
            <form action="../Controller/registrar_usuario.php" method="post" id="formRegistro">  
                <div class="form-group">
                    <h3>Formulario de Registro</h3>
        
                    <label for="cedula">Número de Documento:</label>
                    <div id="mensaje-cedula" class="mensaje-error" style="display:none;"></div>
                    <input type="text" id="cedula" name="cedula" required placeholder="Escriba cédula" pattern="[0-9]{7,11}" maxlength="11"><br><br>
        
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Escriba nombre completo" maxlength="100"><br><br>
        
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="">Seleccione rol</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="docente">Docente</option>
                    </select><br><br>
        
                    <label for="institucion">Institución:</label>
                    <select id="institucion" name="institucion" required>
                        <option value="">Seleccione institución</option>
                        <?php include "../Controller/listar_instituciones.php"; ?>
                    </select><br><br>
                    
                    <label for="email">Email:</label>
                    <div id="mensaje-correo" class="mensaje-error" style="display:none;"></div>
                    <input type="email" id="email" name="email" required placeholder="Escriba email"><br><br>
        
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required placeholder="Escriba contraseña" minlength="6"><br><br>
        
                    <label for="confirm_password">Confirmar contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Repita la contraseña" minlength="6"><br><br>
        
                    <div id="mensaje-general" class="mensaje-error" style="display:none;"></div>
                    
                    <input type="submit" value="Registrar">
                </div>
            </form>
        
    <script src="../JS/validarFormulario.js"></script>
    <script src="../JS/verificarContraseña.js"></script>
    <?php
    session_start();
    
    if (isset($_SESSION['mensaje'])) {
        $mensaje = addslashes($_SESSION['mensaje']);
        $esExito = $_SESSION['esExito'] ? 'true' : 'false';
        $campoError = $_SESSION['campoError'];
    
        $idContenedor = 'mensaje-registro';
        if ($campoError === 'cedula') {
            $idContenedor = 'mensaje-cedula';
        } elseif ($campoError === 'correo') {
            $idContenedor = 'mensaje-correo';
        }
    
        echo "<script>mostrarMensaje(\"$mensaje\", $esExito, \"$idContenedor\");</script>";
    
        // Limpiar variables de sesión después de usarlas
        unset($_SESSION['mensaje'], $_SESSION['esExito'], $_SESSION['campoError'], $_SESSION['resultado']);
    }
    ?>
</body>
</html>