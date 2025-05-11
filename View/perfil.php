<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1>Perfil de Usuario</h1>
    <form action="perfil.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required><br><br>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="admin">Administrador</option>
            <option value="user">Usuario</option>
        </select><br><br>

        <button type="submit">Actualizar Perfil</button>
    </form>
</body>
</html>