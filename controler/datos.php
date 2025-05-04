<?php
$connection_obj = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");

if (!$connection_obj) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT clave FROM usuarios WHERE correo = ?";

    if ($stmt = mysqli_prepare($connection_obj, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Verificar si hay resultados
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $hashed_password);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                // Redirigir a la página principal
                header("Location: ../view/Principal.html?user_email=" . urlencode($email));
                exit();
            } else {
                echo "Error: Contraseña incorrecta";
            }
        } else {
            echo "Error: Usuario no encontrado";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($connection_obj);
    }
}

mysqli_close($connection_obj);
?>
