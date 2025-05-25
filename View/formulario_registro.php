<?php
// archivo: registrar.php (o el que uses para mostrar el formulario)

require_once '../Model/entity/Conexion.php';

// Obtener conexión
$conexion = Conexion::obtenerConexion();

// Consultar instituciones
$query = "SELECT id_institucion, nombre FROM instituciones";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="CSS/formulario.css">
</head>
<body>
    <a href="Principal.php" class="back-button">Inicio</a>
    <form action="../Controller/Autenticacion/RegistrarController.php" method="post" autocomplete="off">
        <div class="form-group">
            <h3>Formulario para insertar</h3>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Escriba nombre completo" maxlength="100"><br><br>

            <label for="cedula">Número de Documento:</label>
            <input type="text" id="cedula" name="cedula" required placeholder="Escriba cédula" maxlength="10" pattern="[0-9]{10}"><br><br>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="">Seleccione rol</option>
                <option value="estudiante">Estudiante</option>
                <option value="docente">Docente</option>
            </select><br><br>

            <label for="institucion">Institución:</label>
            <select id="institucion" name="institucion" required>
                <option value="">Seleccione institución</option>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <option value="<?php echo $row['id_institucion']; ?>">
                        <?php echo htmlspecialchars($row['nombre']); ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Escriba email"><br><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="Escriba contraseña" minlength="6"><br><br>

            <label for="confirmar_password">Confirmar Contraseña:</label>
            <input type="password" id="confirmar_password" name="confirmar_password" required placeholder="Repita la contraseña" minlength="6"><br><br>


            <input type="submit" value="Enviar">
        </div>
    </form>
</body>
</html>
