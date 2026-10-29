<?php
require("conexion.php");

$titulo = $_POST['crear_titulo'];
$genero = $_POST['crear_genero'];
$primer_capitulo = $_POST['crear_primer_capitulo'];
$tiempo = $_POST['crear_tiempo'];
$limite = $_POST['crear_limite'];


$sql = "INSERT INTO historia (
    titulo,
    genero,
    primer_capitulo,
    tiempo_horas_turno,
    limite_palabras
)
VALUES (
    '$titulo',
    '$genero',
    '$primer_capitulo',
    '$tiempo',
    '$limite'
)";

if ($conn->query($sql) === TRUE) {
    echo "Registro guardado correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
