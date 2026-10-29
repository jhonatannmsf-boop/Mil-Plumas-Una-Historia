<?php
require("conexion.php");

$contenido = $_POST['texto_capitulo'];

// Insertar en la base de datos
$sql = "INSERT INTO capitulo(
    contenido
)
VALUES ('$contenido')";

if ($conn->query($sql) === TRUE) {
    echo "Registro guardado correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
