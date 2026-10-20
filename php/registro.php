<?php
require('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];
}
?>
