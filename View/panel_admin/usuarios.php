<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

require_once __DIR__ . '/../../Controller/Admin/UsuarioController.php';

$controller = new UsuarioController();

// Inactivar usuario
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $controller->inactivarUsuario($id);
    header("Location: usuarios.php?success=Usuario+inactivado");
    exit();
}

// Editar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_usuario'])) {
    $controller->editarUsuario([
        'id' => intval($_POST['id']),
        'cedula' => $_POST['cedula'],
        'nombre' => $_POST['nombre'],
        'email' => $_POST['email'],
        'rol' => $_POST['rol'],
        'estado' => intval($_POST['estado'])
    ]);
    header("Location: usuarios.php?success=Usuario+actualizado");
    exit();
}

$usuarios = $controller->obtenerUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../CSS/desafios_crud.css">
</head>
<body>
    <h1>Usuarios Registrados</h1>
        <a href="paneladmin.php">Volver</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>


<!-- Tu HTML de tabla permanece igual, solo cambia el bucle: -->

<?php foreach ($usuarios as $row): ?>
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

<!-- Formulario de edición -->
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
<?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
