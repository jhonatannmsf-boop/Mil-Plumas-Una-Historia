<?php
require('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];
}

$sql = "INSERT INTO usuario (nombre_usuario, contrasena, correo) VALUES ('$usuario', '$contrasena', '$correo')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }

















?>