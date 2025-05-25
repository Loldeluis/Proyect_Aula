<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="login"> 
        <form action="../Controller/Autenticacion/LoginController.php" method="post">
            <h2>LOGIN</h2>
            Email <input type="text" name="email" required><br><br>
            Password <input type="password" name="password" required><br><br>
            <input type="submit" value="Ingresar">
        </form>
        <p class="small-text">¿No tienes cuenta? <a href="formulario_registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
