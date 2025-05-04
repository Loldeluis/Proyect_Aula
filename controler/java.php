<?php
$nivel = $_POST['nivel'] ?? 0;

if (isset($_FILES['codigo'])) {
    $archivo = $_FILES['codigo']['tmp_name'];
    $salida = shell_exec("python3 " . escapeshellarg($archivo));
    
    // Cargar salida esperada
    $data = json_decode(file_get_contents("ejercicio_1.json"), true);
    
    if ($salida === $data['salida_esperada']) {
        echo "✅ ¡Ejercicio $nivel correcto!";
    } else {
        echo "❌ Resultado incorrecto. Salida:<br><pre>$salida</pre>";
    }
}
?>
