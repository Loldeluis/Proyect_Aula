<?php
class Ejercicio {
    private $numero; // Se asume que hay un campo 'numero' como ID primario
    private $lenguaje;
    private $nivel;
    private $estado;
    private $cedulaUsuario;
    private $rutaArchivo;

    public function __construct($numero, $lenguaje, $nivel, $estado, $cedulaUsuario, $rutaArchivo) {
        $this->numero = $numero;
        $this->lenguaje = $lenguaje;
        $this->nivel = $nivel;
        $this->estado = $estado;
        $this->cedulaUsuario = $cedulaUsuario;
        $this->rutaArchivo = $rutaArchivo;
    }

    // Getters
    public function getNumero() {
        return $this->numero;
    }

    public function getLenguaje() {
        return $this->lenguaje;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCedulaUsuario() {
        return $this->cedulaUsuario;
    }

    public function getRutaArchivo() {
        return $this->rutaArchivo;
    }

    // Setters
    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCedulaUsuario($cedulaUsuario) {
        $this->cedulaUsuario = $cedulaUsuario;
    }

    public function setRutaArchivo($rutaArchivo) {
        $this->rutaArchivo = $rutaArchivo;
    }
}
?>
