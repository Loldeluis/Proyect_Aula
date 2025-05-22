<?php
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/entity/Conexion.php');

class EjercicioCrud {
    private $conexion;
    private $root; // Raíz del proyecto

    public function __construct() {
        $this->conexion = Conexion::obtenerConexion();
        $this->root = dirname(dirname(__DIR__)); // Ej: C:\xampp\htdocs\ProyectoAula
    }

    // Crear ejercicios para el usuario al registrarse
    public function crearEjerciciosUsuario($cedula_usuario) {
        $sql_insert = "INSERT INTO tabla_ejercicios (lenguaje, nivel, estado, cedula_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql_insert);
        if (!$stmt) {
            error_log("❌ Error al preparar la inserción de ejercicios: " . $this->conexion->error);
            return false;
        }
        $estado_default = "espera";
        foreach (['Java', 'HTML', 'Python'] as $lenguaje) {
            for ($i = 1; $i <= 30; $i++) {
                $nivel = "Nivel-$i";
                $stmt->bind_param("ssss", $lenguaje, $nivel, $estado_default, $cedula_usuario);
                if (!$stmt->execute()) {
                    error_log("⚠️ Error al asignar ejercicio: " . $stmt->error);
                    return false;
                }
            }
        }
        $stmt->close();
        error_log("✅ Ejercicios generados correctamente para usuario con cédula: $cedula_usuario");
        return true;
    }

    // Obtener ejercicios de un usuario
    public function obtenerEjerciciosPorUsuario($cedula_usuario) {
        $sql = "SELECT * FROM tabla_ejercicios WHERE cedula_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $cedula_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $ejercicios = [];
        while ($row = $resultado->fetch_assoc()) {
            $ejercicios[] = $row;
        }
        return $ejercicios;
    }

    // Actualizar estado de un ejercicio usando lenguaje, nivel y cedula
    public function actualizarEstadoEjercicio($lenguaje, $numeroEjercicio, $estado, $cedulaUsuario) {
        // Se supone que el campo "nivel" tiene el formato "Nivel-X"
        $nivel = "Nivel-" . $numeroEjercicio;
        $sql = "UPDATE tabla_ejercicios SET estado = ? WHERE lenguaje = ? AND nivel = ? AND cedula_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar la actualización: " . $this->conexion->error);
            return false;
        }
        $stmt->bind_param("ssss", $estado, $lenguaje, $nivel, $cedulaUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    // Procesar la subida de archivos y ejecutar pruebas
    public function procesarArchivo($lenguaje, $numeroEjercicio, $archivo) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Acceso no permitido");
        }
        
        if (!isset($archivo)) {
            die("Faltan datos del formulario.");
        }
        
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            die("Error al subir el archivo. Código de error: " . $archivo['error']);
        }
        
        if (!$this->validarExtension($archivo, $lenguaje)) {
            die("El archivo debe tener extensión ." . strtolower($lenguaje));
        }
        
        $contenido = file_get_contents($archivo['tmp_name']);
        if (trim($contenido) === "") {
            die("El archivo está vacío.");
        }
        
        $salidaEsperada = $this->obtenerSalidaEsperada($lenguaje, $numeroEjercicio);
        if ($salidaEsperada === "") {
            die("No se definió la salida esperada en el archivo JSON.");
        }
        
        $rutaArchivo = $this->guardarArchivo($lenguaje, $numeroEjercicio, $archivo, $contenido);
        return $this->ejecutarArchivo($lenguaje, $rutaArchivo, $salidaEsperada);
    }

    // Validar extensión del archivo
    private function validarExtension($archivo, $lenguaje) {
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $lenguaje = strtolower($lenguaje);
    
        if ($lenguaje === "python") {
            return $extension === "py";
        }
        if ($lenguaje === "java") {
            return $extension === "java";
        }
        if ($lenguaje === "html") {
            return $extension === "html" || $extension === "htm";
        }
        return false;
    }

    // Obtener salida esperada desde JSON
    private function obtenerSalidaEsperada($lenguaje, $numeroEjercicio) {
        $jsonPath = $this->root . "/Controller/Ejercicio_cargados/" . strtolower($lenguaje) . "-json/ejercicio_{$numeroEjercicio}.json";
        error_log("Buscando JSON en: " . $jsonPath);
        if (!file_exists($jsonPath)) {
            die("No se encontró el archivo JSON del ejercicio en: $jsonPath");
        }
        $data = json_decode(file_get_contents($jsonPath), true);
        return trim($data['salida_esperada'] ?? "");
    }

    // Guardar archivo del ejercicio
    private function guardarArchivo($lenguaje, $numeroEjercicio, $archivo, $contenido) {
    $rutaBase = $this->root . DIRECTORY_SEPARATOR . "Controller" . DIRECTORY_SEPARATOR . "Ejercicio_cargados" . DIRECTORY_SEPARATOR .
                "entregas-" . strtolower($lenguaje) . DIRECTORY_SEPARATOR . "ejercicio_{$numeroEjercicio}" . DIRECTORY_SEPARATOR;
    if (!is_dir($rutaBase)) {
        mkdir($rutaBase, 0777, true);
    }
    $nombreBase = pathinfo($archivo['name'], PATHINFO_FILENAME);
    $ext = strtolower($lenguaje);
    if ($ext === "python") {
        $ext = "py";
    }
    $rutaArchivo = $rutaBase . $nombreBase . '.' . $ext;
    file_put_contents($rutaArchivo, $contenido);
    
    error_log("Archivo guardado en: " . $rutaArchivo);
    
    if (!file_exists($rutaArchivo)) {
        die("Error: el archivo no se encontró en la ruta esperada: " . $rutaArchivo);
    }
    
    return $rutaArchivo;
}



    // Ejecutar el archivo y comparar la salida
    private function ejecutarArchivo($lenguaje, $rutaArchivo, $salidaEsperada) {
        $comando = $this->obtenerComandoEjecutar($lenguaje, $rutaArchivo) . " 2>&1";
        exec($comando, $output, $codigoEjecucion);
        if ($codigoEjecucion !== 0) {
            $errorMsg = "❌ Error al ejecutar el archivo " . strtolower($lenguaje) . ".\nComando: $comando\nCódigo: $codigoEjecucion\nSalida:\n" . implode("\n", $output);
            error_log($errorMsg);
            die("<pre>$errorMsg</pre>");
        }
        $salidaReal = trim(implode("\n", $output));
        return $this->compararSalida($lenguaje, $salidaReal, $salidaEsperada);
    }

    // Obtener comando de ejecución según lenguaje
   private function obtenerComandoEjecutar($lenguaje, $rutaArchivo) {
    $os = strtoupper(substr(PHP_OS, 0, 3));
    error_log("OS detectado: " . $os);
    switch (strtolower($lenguaje)) {
        case "python":
            if ($os === 'WIN') {
                // Usamos el lanzador "py -3" para ejecutar Python 3 en Windows
                return "py -3 " . escapeshellarg($rutaArchivo);
            } else {
                return "python3 " . escapeshellarg($rutaArchivo);
            }
        case "java":
            $rutaDir = escapeshellarg(dirname($rutaArchivo));
            $nombreClase = escapeshellarg(pathinfo($rutaArchivo, PATHINFO_FILENAME));
            return "javac " . escapeshellarg($rutaArchivo) . " && java -cp $rutaDir $nombreClase";
        case "html":
            return $os === 'WIN'
                ? "type " . escapeshellarg($rutaArchivo)
                : "cat " . escapeshellarg($rutaArchivo);
        default:
            die("Lenguaje no soportado.");
    }
}



    // Comparar la salida real con la salida esperada
    private function compararSalida($lenguaje, $salidaReal, $salidaEsperada) {
        if (strtolower($lenguaje) === "html") {
            $normalizar = function ($html) {
                return preg_replace('/\s+/', '', strip_tags(strtolower($html)));
            };
            $salidaReal = $normalizar($salidaReal);
            $salidaEsperada = $normalizar($salidaEsperada);
        } else {
            $salidaReal = trim($salidaReal);
            $salidaEsperada = trim($salidaEsperada);
        }
        if ($salidaReal === $salidaEsperada) {
            return "✅ ¡Ejercicio correcto!<br><strong>Salida:</strong><pre>$salidaReal</pre>";
        } else {
            return "❌ Resultado incorrecto.<br><strong>Tu salida:</strong><pre>$salidaReal</pre><strong>Esperado:</strong><pre>$salidaEsperada</pre>";
        }
    }
}
?>
