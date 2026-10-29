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

    echo "Inicio de sesión exitoso. Bienvenido, " . $usuario . ". <a href='../modulos/explorar.html'>Ir a explorar</a>";
} else {
    echo "Usuario o contraseña incorrectos. <a href='../modulos/login.html'>Intentar de nuevo</a>";
}
?>
