<?php

ob_start();
require_once("conexion.php");
ob_end_clean();

header("Content-Type: application/json");

$sql = "SELECT id_historia, titulo, genero, portada FROM historia
        ORDER BY fecha_creacion DESC";

$resultado = $conn->query($sql);

$historias = [];

while ($fila = $resultado->fetch_assoc()) {
    $historias[] = $fila;
}

echo json_encode($historias);

?>
