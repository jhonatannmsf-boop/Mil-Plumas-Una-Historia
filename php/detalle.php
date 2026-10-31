<?php

ob_start();
require_once("conexion.php");
ob_end_clean();

header("Content-Type: application/json");

$id_historia = (int) $_GET['id'];

$sql = "SELECT id_historia, titulo, genero, primer_capitulo, limite_palabras
        FROM historia
        WHERE id_historia = '$id_historia'";

$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
    echo json_encode(["error" => "La historia no existe"]);
    exit();
}

$historia = $resultado->fetch_assoc();


$sql = "SELECT capitulo.numero_turno, capitulo.contenido, usuario.nombre_usuario
        FROM capitulo
        LEFT JOIN usuario ON usuario.id_usuario = capitulo.id_usuario
        WHERE capitulo.id_historia = '$id_historia'
        ORDER BY capitulo.numero_turno ASC";

$resultado = $conn->query($sql);

$turnos = [];

while ($fila = $resultado->fetch_assoc()) {
    $turnos[] = $fila;
}

$historia['turnos'] = $turnos;

echo json_encode($historia);

?>
