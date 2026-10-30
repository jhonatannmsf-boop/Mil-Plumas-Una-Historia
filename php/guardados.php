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

$id_usuario = $_SESSION['id_usuario'];
$id_historia = (int) $_POST['id_historia'];
$accion = $_POST['accion'];


$sql = "SELECT * FROM me_gusta
        WHERE id_usuario = '$id_usuario'
        AND id_historia = '$id_historia'";

$resultado = $conn->query($sql);

if ($accion == "cambiar") {

    if ($resultado->num_rows > 0) {

        $sql = "DELETE FROM me_gusta
                WHERE id_usuario = '$id_usuario'
                AND id_historia = '$id_historia'";

    } else {

        $sql = "INSERT INTO me_gusta (id_usuario, id_historia)
                VALUES ('$id_usuario', '$id_historia')";

    }

    $conn->query($sql);

}


$sql = "SELECT * FROM me_gusta
        WHERE id_usuario = '$id_usuario'
        AND id_historia = '$id_historia'";

$resultado = $conn->query($sql);

$me_gusta = ($resultado->num_rows > 0);


$sql = "SELECT COUNT(*) AS total FROM me_gusta
        WHERE id_historia = '$id_historia'";

$resultado = $conn->query($sql);
$fila = $resultado->fetch_assoc();

echo json_encode([
    "me_gusta" => $me_gusta,
    "total" => $fila['total']
]);

?>