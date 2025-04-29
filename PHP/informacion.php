<?php
require_once 'conexion.php';

if (!$connection_obj) {
    echo "Error No: " . mysqli_connect_errno();
    echo "Error Description: " . mysqli_connect_error();
    exit;
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar entradas
    $name = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rol = $_POST['rol'];
    $id_institucion = $_POST['institucion'];

    // Validar que campos no estén vacíos (extra seguro)
    if (empty($name) || empty($cedula) || empty($email) || empty($password) || empty($rol) || empty($id_institucion)) {
        echo "Por favor, complete todos los campos.";
        exit;
    }

    // Hashear la contraseña antes de almacenarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta
    $query = "INSERT INTO usuarios (nombre_usuario, correo, clave, cedula, rol, estado, fecha_registro, id_institucion) 
              VALUES (?, ?, ?, ?, ?, 1, NOW(), ?)";

    if ($stmt = mysqli_prepare($connection_obj, $query)) {
        // Enlazar parámetros
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $hashed_password, $cedula, $rol, $id_institucion);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "Datos insertados correctamente.";
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
