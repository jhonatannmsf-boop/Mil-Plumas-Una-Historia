<?php
require("conexion.php");

$contenido = $_POST['texto_capitulo'];

// Insertar en la base de datos
$sql = "INSERT INTO capitulo(
    contenido
)
VALUES ('$contenido')";

if ($conn->query($sql) === TRUE) {
    Alerta("success", "¡Capítulo creado con éxito!", "../modulos/explorar.html");
} else {
    Alerta("error", "Error al crear el capítulo: " . $conn->error, "../modulos/editor.html");
}
?>
