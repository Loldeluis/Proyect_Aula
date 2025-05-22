<?php
class Usuario {
    private $nombre, $cedula, $email, $password, $rol;

    public function __construct($nombre, $cedula, $email, $password, $rol) {
        $this->nombre = $nombre;
        $this->cedula = $cedula;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function getNombre() { return $this->nombre; }
    public function getCedula() { return $this->cedula; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRol() { return $this->rol; }
}
