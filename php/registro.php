<?php
require('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "INSERT INTO usuario (nombre_usuario, correo, contrasena) VALUES ('$usuario', '$correo', '$contrasena')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente. <a href='../modulos/login.html'>Iniciar sesión</a>";
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }
}
?>
