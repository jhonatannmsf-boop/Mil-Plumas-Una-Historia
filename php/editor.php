<?php
require('conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contenido = $_POST['texto_capitulo'];

    // Obtener un id de usuario (de la sesión o el primero registrado)
    $id_usuario = 1;
    if (isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
    } else {
        $res_usuario = $conn->query("SELECT id_usuario FROM usuario LIMIT 1");
        if ($res_usuario && $fila = $res_usuario->fetch_assoc()) {
            $id_usuario = $fila['id_usuario'];
        }
    }

    // Obtener la historia más reciente
    $id_historia = 1;
    $res_historia = $conn->query("SELECT id_historia FROM historia ORDER BY id_historia DESC LIMIT 1");
    if ($res_historia && $fila = $res_historia->fetch_assoc()) {
        $id_historia = $fila['id_historia'];
    }

    // Determinar el número del siguiente turno
    $numero_turno = 1;
    $res_turno = $conn->query("SELECT MAX(numero_turno) AS max_turno FROM capitulo WHERE id_historia = '$id_historia'");
    if ($res_turno && $fila = $res_turno->fetch_assoc()) {
        if ($fila['max_turno'] !== null) {
            $numero_turno = $fila['max_turno'] + 1;
        }
    }

    $sql = "INSERT INTO capitulo (id_historia, id_usuario, numero_turno, contenido) VALUES ('$id_historia', '$id_usuario', '$numero_turno', '$contenido')";

    if ($conn->query($sql) === TRUE) {
        echo "Turno publicado exitosamente. <a href='../modulos/detalle.html'>Volver a la historia</a>";
    } else {
        echo "Error al publicar el turno: " . $conn->error;
    }
}
?>
