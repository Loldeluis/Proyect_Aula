<?php
define('BASE_URL', 'http://localhost/Proyect_Aula-main/');
session_start();
session_destroy();
header('Location: '.BASE_URL.'/view/principal.php');
exit();
?>
