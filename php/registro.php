<?php
require("conexion.php");

$usuario = $_POST['nombre_usuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];


$sql = "INSERT INTO usuario(
    nombre_usuario,
    correo,
    contrasena
)
VALUES ('$usuario', '$correo', '$contrasena')";

if ($conn->query($sql) === TRUE) {
    alerta("success", "¡Cuenta creada con éxito!", "../index.html");
} else {
    Alerta("error", "Error al crear la cuenta: " . $conn->error, "../modulos/registro.html");
}
?>
