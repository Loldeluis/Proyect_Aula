<?php
$connection_obj = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consulta para obtener la contraseña
    $query = "SELECT clave FROM usuarios WHERE correo = ?";
    
    if ($stmt = mysqli_prepare($connection_obj, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);      
        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            header("Location: Principal.html");
            exit();
        } else {
            echo "Error: Contraseña incorrecta";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($connection_obj);
    }
}
}
mysqli_close($connection_obj);
?>