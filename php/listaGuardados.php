<?php

session_start();

ob_start();
require_once("conexion.php");
ob_end_clean();

header("Content-Type: application/json");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([]);
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT historia.id_historia, historia.titulo, historia.genero
        FROM me_gusta
        INNER JOIN historia ON historia.id_historia = me_gusta.id_historia
        WHERE me_gusta.id_usuario = '$id_usuario'
        ORDER BY me_gusta.fecha_like DESC";

$resultado = $conn->query($sql);

$guardados = [];

while ($fila = $resultado->fetch_assoc()) {
    $guardados[] = $fila;
}

echo json_encode($guardados);

?>
