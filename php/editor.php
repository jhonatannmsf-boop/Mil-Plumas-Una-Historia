<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../modulos/login.html");
    exit();
}

require("conexion.php");
require_once("alert.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_historia']) || !isset($_POST['texto_capitulo'])) {
    $id_historia = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id_historia']) ? (int) $_POST['id_historia'] : 0);
    if ($id_historia > 0) {
        header("Location: ../modulos/detalle.html?id=" . $id_historia);
    } else {
        header("Location: ../modulos/explorar.html");
    }
    exit();
}

$id_historia = (int) $_POST['id_historia'];
$id_usuario = (int) $_SESSION['id_usuario'];
$contenido = $conn->real_escape_string($_POST['texto_capitulo']);
$cantidad_palabras = count(preg_split('/\s+/', trim($_POST['texto_capitulo']), -1, PREG_SPLIT_NO_EMPTY));

$sqlCheck = "SELECT id_usuario FROM participacion 
             WHERE id_historia = '$id_historia' AND es_turno_actual = 1";
$resCheck = $conn->query($sqlCheck);
$filaCheck = $resCheck ? $resCheck->fetch_assoc() : null;

if (!$filaCheck || (int) $filaCheck['id_usuario'] !== $id_usuario) {
    alerta("error", "No tienes el turno activo para esta historia.", "../modulos/detalle.html?id=" . $id_historia);
    exit();
}

$conn->query("UPDATE participacion SET es_turno_actual = 0 WHERE id_historia = '$id_historia'");

if ($cantidad_palabras < 10) {
    alerta("info", "El turno finalizó sin cambios porque no alcanzó el mínimo de 10 palabras.", "../modulos/detalle.html?id=" . $id_historia);
    exit();
}


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
