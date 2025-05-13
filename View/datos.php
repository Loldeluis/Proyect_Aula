<?php
session_start();

$connection_obj = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");

// Verifica la conexión
if (!$connection_obj) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consulta que trae la clave, nombre de usuario y rol
    $query = "SELECT id_usuario, clave, nombre_usuario, rol, estado FROM usuarios WHERE correo = ?";

    if ($stmt = mysqli_prepare($connection_obj, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id_usuario, $hashed_password, $nombre_usuario, $rol, $estado);
    
        if (mysqli_stmt_fetch($stmt)) {
            if ($estado != 1) {
                echo "<script>alert('Usuario inactivo'); window.location.href='login.html';</script>";
                exit();
            }
    
            if (password_verify($password, $hashed_password)) {
                $_SESSION['usuario_id'] = $id_usuario;  // <-- NUEVO
                $_SESSION['correo'] = $email;
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['rol'] = $rol;
    
                // Redirección según el rol
                if ($rol === 'docente') {
                    header("Location: docente.php");
                } elseif ($rol === 'estudiante') {
                    header("Location: principal.php");
                } elseif ($rol === 'admin') {
                    header("Location: admin.php"); 
                } else {
                    echo "<script>alert('Rol no reconocido'); window.location.href='login.html';</script>";
                }
                exit();
            } else {
                echo "<script>alert('Contraseña incorrecta'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('Usuario no encontrado'); window.location.href='login.html';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la consulta: " . mysqli_error($connection_obj);
    }
}

mysqli_close($connection_obj);
?>
