<?php
class Conexion {
    private static $instancia = null;
    private $conexion;

    // Hacemos el constructor privado para evitar instanciación directa
    private function __construct() {
        $host = "localhost"; 
        $user = "root"; 
        $password = ""; 
        $database = "bd_sistemaeducativo";
        
        $this->conexion = mysqli_connect($host, $user, $password, $database);
        
        if (!$this->conexion) {
            throw new Exception(
                "Error de conexión MySQL: " . mysqli_connect_errno() . " - " . mysqli_connect_error()
            );
        }
        
        mysqli_set_charset($this->conexion, 'utf8mb4');
    }

    // Método estático para obtener la instancia única
    public static function getConexion() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia->conexion;
    }

    // Método para cerrar la conexión
    public static function cerrarConexion() {
        if (self::$instancia !== null && self::$instancia->conexion !== null) {
            mysqli_close(self::$instancia->conexion);
            self::$instancia->conexion = null;
            self::$instancia = null;
        }
    }

    // Evitamos la clonación del objeto
    private function __clone() {}
    
    // Evitamos la deserialización del objeto
    private function __wakeup() {}
}