<?php
include("conexion.php");

$titulo = $_POST['crear_titulo'];
$genero = $_POST['crear_genero'];
$primer_capitulo = $_POST['crear_primer_capitulo'];


$sql = "INSERT INTO historia(
    titulo,
    genero,
    primer_capitulo
)
VALUES ('$titulo', '$genero', '$primer_capitulo')";

if ($conn->query($sql) === TRUE) {
    echo "Registro guardado correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
