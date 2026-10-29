<?php
    require_once("alert.php");

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mil_plumas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
?>
