<?php
session_start();
require("conexion.php");

$usuario = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];

// Consultar en la base de datos
$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario' AND contrasena = '$contrasena'";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];

    Alerta("success", "¡Inicio de sesión exitoso!", "../modulos/explorar.html");
} else {
    Alerta("error", "Usuario o contraseña incorrectos.", "../modulos/login.html");
}
?>
