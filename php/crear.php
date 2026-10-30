<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../modulos/login.html");
    exit();
}


require("conexion.php");
require_once("alert.php");

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
    alerta("success", "¡Historia creada con éxito!", "../modulos/explorar.html");
} else {
    alerta("error", "Error al crear la historia: " . $conn->error, "../modulos/crear.html");
}
?>
