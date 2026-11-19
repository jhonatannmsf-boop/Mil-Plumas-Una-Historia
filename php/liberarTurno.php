<?php

session_start();

require("conexion.php");

$id_historia = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id_historia']) ? (int) $_POST['id_historia'] : 0);

if (isset($_SESSION['id_usuario']) && $id_historia > 0) {
    $id_usuario = (int) $_SESSION['id_usuario'];

    $conn->query("UPDATE participacion 
                  SET es_turno_actual = 0 
                  WHERE id_historia = '$id_historia' 
                  AND id_usuario = '$id_usuario'");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json");
    echo json_encode(["ok" => true]);
    exit();
}

header("Location: ../modulos/detalle.html?id=" . $id_historia);
exit();
?>
