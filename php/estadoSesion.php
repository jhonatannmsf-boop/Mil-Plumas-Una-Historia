<?php

session_start();

if (isset($_SESSION['id_usuario'])) {

    echo json_encode([
        "sesion" => true,
        "nombre" => $_SESSION['nombre_usuario']
    ]);

} else {

    echo json_encode([
        "sesion" => false
    ]);

}

?>