<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../login.html");
    exit();
}

$connection_obj = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");

// Procesar eliminación inmediata
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $query = "UPDATE usuarios SET estado = 0 WHERE id_usuario = $id";
    mysqli_query($connection_obj, $query);
    header("Location: usuarios.php?success=Usuario+inactivado");
    exit();
}

// Procesar edición inmediata (formulario embebido)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar_usuario'])) {
    $id = intval($_POST['id']);
    $cedula = mysqli_real_escape_string($connection_obj, $_POST['cedula']);
    $nombre = mysqli_real_escape_string($connection_obj, $_POST['nombre']);
    $email = mysqli_real_escape_string($connection_obj, $_POST['email']);
    $rol = mysqli_real_escape_string($connection_obj, $_POST['rol']);
    $estado = intval($_POST['estado']);
    
    $query = "UPDATE usuarios SET 
              cedula = '$cedula', 
              nombre_usuario = '$nombre', 
              correo = '$email', 
              rol = '$rol', 
              estado = $estado 
              WHERE id_usuario = $id";
    
    mysqli_query($connection_obj, $query);
    header("Location: usuarios.php?success=Usuario+actualizado");
    exit();
}

// Obtener usuarios
$query = "SELECT id_usuario, cedula, nombre_usuario, correo, rol, estado FROM usuarios";
$result = mysqli_query($connection_obj, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id_usuario'] ?></td>
                    <td><?= $row['cedula'] ?></td>
                    <td><?= $row['nombre_usuario'] ?></td>
                    <td><?= $row['correo'] ?></td>
                    <td><?= ucfirst($row['rol']) ?></td>
                    <td><?= ($row['estado'] == 1) ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="usuarios.php?editar=<?= $row['id_usuario'] ?>">✏️</a>
                        <a href="usuarios.php?eliminar=<?= $row['id_usuario'] ?>" 
                           onclick="return confirm('¿Inactivar usuario?')">🗑️</a>
                    </td>
                </tr>
                
                <!-- Formulario de edición (aparece cuando se hace clic en ✏️) -->
                <?php if (isset($_GET['editar']) && $_GET['editar'] == $row['id_usuario']): ?>
                <tr>
                    <td colspan="7">
                        <form method="POST" action="usuarios.php">
                            <input type="hidden" name="editar_usuario" value="1">
                            <input type="hidden" name="id" value="<?= $row['id_usuario'] ?>">
                            
                            <label>Cédula:</label>
                            <input type="text" name="cedula" value="<?= $row['cedula'] ?>" required>
                            
                            <label>Nombre:</label>
                            <input type="text" name="nombre" value="<?= $row['nombre_usuario'] ?>" required>
                            
                            <label>Email:</label>
                            <input type="email" name="email" value="<?= $row['correo'] ?>" required>
                            
                            <label>Rol:</label>
                            <select name="rol" required>
                                <option value="admin" <?= $row['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                                <option value="docente" <?= $row['rol'] == 'docente' ? 'selected' : '' ?>>Docente</option>
                                <option value="estudiante" <?= $row['rol'] == 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
                            </select>
                            
                            <label>Estado:</label>
                            <select name="estado" required>
                                <option value="1" <?= $row['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                                <option value="0" <?= $row['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                            
                            <button type="submit">Guardar</button>
                            <a href="usuarios.php">Cancelar</a>
                        </form>
                    </td>
                </tr>
                <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <a href="registrar_usuario.php" class="btn">Registrar Nuevo Usuario</a>
        <a href="paneladmin.php" class="btn">Volver</a>
    </div>
</body>
</html>
<?php mysqli_close($connection_obj); ?>