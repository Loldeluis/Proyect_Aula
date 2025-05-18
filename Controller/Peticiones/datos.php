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
                $_SESSION['usuario_id'] = $id_usuario;
                $_SESSION['correo'] = $email;
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['rol'] = $rol;

                
$acceso_docente = ($rol === 'docente') ? 1 : 0;
$acceso_estudiante = ($rol === 'estudiante') ? 1 : 0;
// Puedes usar $_SESSION['id_institucion'] si ya la manejas, o dejarlo como NULL
$id_institucion = null; 

$log_query = "INSERT INTO accesos_usuario (id_usuario, id_institucion, acceso_docente, acceso_estudiante, fecha_entrada, estado_acceso)
    VALUES (?, ?, ?, ?, NOW(), ?)";

if ($log_stmt = mysqli_prepare($connection_obj, $log_query)) {
    $estado_acceso = "Éxito";
    mysqli_stmt_bind_param($log_stmt, "iiiis", $id_usuario, $id_institucion, $acceso_docente, $acceso_estudiante, $estado_acceso);
    if (mysqli_stmt_execute($log_stmt)) {
    $id_acceso = mysqli_insert_id($connection_obj); // OBTIENE el id_acceso recién insertado
    $_SESSION['id_acceso'] = $id_acceso; // GUÁRDALO para usarlo al cerrar sesión
} else {
    echo "<script>alert('Error al registrar acceso: " . mysqli_error($connection_obj) . "');</script>";
}

    mysqli_stmt_close($log_stmt);
}

    

                    mysqli_stmt_close($log_stmt);
                } else {
                    echo "<script>alert('Error al registrar acceso: " . mysqli_error($connection_obj) . "');</script>";
                }

                // Redirección según el rol
                if ($rol === 'docente') {
                    header("Location: ../../View/Panel_docente/docente.php");
                } elseif ($rol === 'estudiante') {
                    header("Location: ../../View/principal.php");
                } elseif ($rol === 'admin') {
                    header("Location: ../../View/panel_admin/paneladmin.php");
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
        echo "Error en la consulta de usuario: " . mysqli_error($connection_obj);
    }


mysqli_close($connection_obj);
?>