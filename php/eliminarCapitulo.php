<?php

session_start();

ob_start();
require_once("conexion.php");
ob_end_clean();

header("Content-Type: application/json");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Debes iniciar sesión"]);
    exit();
}

$id_capitulo = isset($_POST['id_capitulo']) ? (int) $_POST['id_capitulo'] : 0;

$sql = "SELECT capitulo.id_historia, capitulo.numero_turno, historia.id_usuario_creador
        FROM capitulo
        INNER JOIN historia ON historia.id_historia = capitulo.id_historia
        WHERE capitulo.id_capitulo = '$id_capitulo'";

$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
    echo json_encode(["error" => "El capítulo no existe"]);
    exit();
}

$capitulo = $resultado->fetch_assoc();
$id_sesion = (int) $_SESSION['id_usuario'];

if ($capitulo['id_usuario_creador'] === null || (int) $capitulo['id_usuario_creador'] !== $id_sesion) {
    echo json_encode(["error" => "Solo el creador de la historia puede eliminar capítulos"]);
    exit();
}

$id_historia = (int) $capitulo['id_historia'];
$numero_borrado = (int) $capitulo['numero_turno'];

$sqlDelete = "DELETE FROM capitulo WHERE id_capitulo = '$id_capitulo'";

if ($conn->query($sqlDelete) === TRUE) {
    $sqlRenum = "UPDATE capitulo
                 SET numero_turno = numero_turno - 1
                 WHERE id_historia = '$id_historia'
                 AND numero_turno > '$numero_borrado'";
    $conn->query($sqlRenum);

    echo json_encode(["ok" => true]);
} else {
    echo json_encode(["error" => "No se pudo eliminar el capítulo"]);
}

?>
