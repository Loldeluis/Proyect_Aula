<?php
$connection_obj = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");

if (!$connection_obj) {
    echo "Error No: " . mysqli_connect_errno();
    echo "Error Description: " . mysqli_connect_error();
    exit;
}

// Initialize variables for the insert query 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rol = $_POST['rol'];

    // Hashear la contraseña antes de almacenarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta con sentencias preparadas
    $query = "INSERT INTO usuarios (cedula, nombre_usuario, correo, clave, rol) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connection_obj, $query)) {
        // Enlazar parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $cedula, $name, $email, $hashed_password, $rol);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "Datos insertados correctamente";
            header("Location: principal.php");
        } else {
            echo "Error al insertar los datos: " . mysqli_error($connection_obj);
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($connection_obj);
    }
}

// Cerrar la conexión
mysqli_close($connection_obj);
?>
