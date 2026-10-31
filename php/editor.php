<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../modulos/login.html");
    exit();
}

require("conexion.php");
require_once("alert.php");

$id_historia = (int) $_POST['id_historia'];
$id_usuario = $_SESSION['id_usuario'];
$contenido = $conn->real_escape_string($_POST['texto_capitulo']);
$cantidad_palabras = count(preg_split('/\s+/', trim($_POST['texto_capitulo']), -1, PREG_SPLIT_NO_EMPTY));


$sql = "SELECT COUNT(*) AS total FROM capitulo
        WHERE id_historia = '$id_historia'";

$resultado = $conn->query($sql);
$fila = $resultado->fetch_assoc();
$numero_turno = $fila['total'] + 1;


$sql = "INSERT INTO capitulo(
    id_historia,
    id_usuario,
    numero_turno,
    contenido,
    cantidad_palabras
)
VALUES (
    '$id_historia',
    '$id_usuario',
    '$numero_turno',
    '$contenido',
    '$cantidad_palabras'
)";

if ($conn->query($sql) === TRUE) {
    alerta("success", "¡Capítulo creado con éxito!", "../modulos/detalle.html?id=" . $id_historia);
} else {
    alerta("error", "Error al crear el capítulo: " . $conn->error, "../modulos/editor.html?id=" . $id_historia);
}
?>
