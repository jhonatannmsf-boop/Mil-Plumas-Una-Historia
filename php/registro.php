<?php
include("conexion.php");

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
    echo "Registro guardado correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
