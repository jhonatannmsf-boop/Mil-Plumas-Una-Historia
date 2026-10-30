<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../modulos/login.html");
    exit();
}

require("conexion.php");
require_once("alert.php");

$contenido = $_POST['texto_capitulo'];


$sql = "INSERT INTO capitulo(
    contenido
)
VALUES ('$contenido')";

if ($conn->query($sql) === TRUE) {
    alerta("success", "¡Capítulo creado con éxito!", "../modulos/explorar.html");
} else {
    alerta("error", "Error al crear el capítulo: " . $conn->error, "../modulos/editor.html");
}
?>
