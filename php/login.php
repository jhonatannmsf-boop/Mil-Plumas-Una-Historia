<?php
require("conexion.php");
require_once("alert.php");
session_start();
$usuario = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];




$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario' AND contrasena = '$contrasena'";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];
    

    alerta("success", "¡Inicio de sesión exitoso!", "../modulos/perfil.html");
} else {
    alerta("error", "Usuario o contraseña incorrectos.", "../modulos/login.html");
}
?>

