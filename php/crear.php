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


$portada = trim($_POST['crear_portada']);

if (!filter_var($portada, FILTER_VALIDATE_URL) || !preg_match('/^https?:\/\//i', $portada)) {
    alerta("error", "La URL de la portada no es válida.", "../modulos/crear.html");
    exit();
}

$portada = $conn->real_escape_string($portada);


$sql = "INSERT INTO historia (
    titulo,
    genero,
    primer_capitulo,
    tiempo_horas_turno,
    limite_palabras,
    portada
)
VALUES (
    '$titulo',
    '$genero',
    '$primer_capitulo',
    '$tiempo',
    '$limite',
    '$portada'
)";

if ($conn->query($sql) === TRUE) {
    alerta("success", "¡Historia creada con éxito!", "../modulos/explorar.html");
} else {
    alerta("error", "Error al crear la historia: " . $conn->error, "../modulos/crear.html");
}
?>
