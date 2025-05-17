<?php
define('BASE_URL', 'http://localhost/ProyectoAula/');
session_start();
session_destroy();
header('Location: '.BASE_URL.'/View/principal.php');
exit();
?>
