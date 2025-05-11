<?php
session_start();
$connection_obj = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");

if (!$connection_obj) {
    die("Error de conexión: " . mysqli_connect_error());
}

// --- LÓGICA DE REGISTRO (desde panel admin) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $name = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rol = $_POST['rol'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (cedula, nombre_usuario, correo, clave, rol, estado) VALUES (?, ?, ?, ?, ?, 1)";
    $stmt = mysqli_prepare($connection_obj, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $cedula, $name, $email, $hashed_password, $rol);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: panel_admin/usuarios.php?success=Usuario+registrado");
    } else {
        header("Location: panel_admin/registrar_usuario.php?error=" . urlencode(mysqli_error($connection_obj)));
    }
    exit();
}

// --- LÓGICA DE LOGIN (desde login.html) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && !isset($_POST['nombre'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Complete todos los campos'); window.location.href='login.html';</script>";
        exit();
    }

    $query = "SELECT id_usuario, clave, nombre_usuario, rol, estado FROM usuarios WHERE correo = ?";
    $stmt = mysqli_prepare($connection_obj, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_usuario, $hashed_password, $nombre_usuario, $rol, $estado);

    if (mysqli_stmt_fetch($stmt)) {
        if ($estado != 1) {
            echo "<script>alert('Usuario inactivo'); window.location.href='login.html';</script>";
            exit();
        }

        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario_id'] = $id_usuario;
            $_SESSION['correo'] = $email;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['rol'] = $rol;

            // Redirección por rol
            if ($rol === 'admin') {
                header("Location: panel_admin/paneladmin.php");
            } elseif ($rol === 'docente') {
                header("Location: docente.php");
            } else {
                header("Location: principal.php");
            }
            exit();
        }
    }
    echo "<script>alert('Credenciales incorrectas'); window.location.href='login.html';</script>";
}

mysqli_close($connection_obj);
?>