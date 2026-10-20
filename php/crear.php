<?php
require('conexion.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['crear_titulo'];
    $primer_capitulo = $_POST['crear_primer_capitulo'];

    
    $id_usuario = 1;
    if (isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
    } else {
        $res_usuario = $conn->query("SELECT id_usuario FROM usuario LIMIT 1");
        if ($res_usuario && $fila = $res_usuario->fetch_assoc()) {
            $id_usuario = $fila['id_usuario'];
        }
    }

    $sql = "INSERT INTO historia (titulo, id_usuario_creador) VALUES ('$titulo', '$id_usuario')";

    if ($conn->query($sql) === TRUE) {
        $id_historia = $conn->insert_id;
        $sql_capitulo = "INSERT INTO capitulo (id_historia, id_usuario, numero_turno, contenido) VALUES ('$id_historia', '$id_usuario', 1, '$primer_capitulo')";
        $conn->query($sql_capitulo);

        echo "Historia creada exitosamente. <a href='../modulos/explorar.html'>Ver historias</a>";
    } else {
        echo "Error al crear la historia: " . $conn->error;
    }
}
?>