<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$database = "bd_sistemaeducativo"; 

$connection_obj = mysqli_connect($host, $user, $password, $database);

if (!$connection_obj) {
    echo "Error No: " . mysqli_connect_errno();
    echo "Error Description: " . mysqli_connect_error();
    exit;
}
?>