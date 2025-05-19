<?php
session_start();
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';
$conexionBD = new ConexionBD();
$connection_obj = $conexionBD->conectar(); // objeto mysqli


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

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $cedula, $name, $email, $hashed_password, $rol);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: ../View/panel_admin/usuarios.php?success=Usuario+registrado");
            exit();
        } else {
            $error = mysqli_error($connection_obj);
            mysqli_stmt_close($stmt);
            header("Location: ../View/panel_admin/registrar_usuario.php?error=" . urlencode($error));
            exit();
        }
    } else {
        $error = mysqli_error($connection_obj);
        header("Location: ../View/panel_admin/registrar_usuario.php?error=" . urlencode("Error en prepare: " . $error));
        exit();
    }
}
?>
