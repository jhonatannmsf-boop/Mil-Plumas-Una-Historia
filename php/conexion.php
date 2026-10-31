<?php
    require_once("alert.php");

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mil_plumas";

    if (file_exists(__DIR__ . "/config.local.php")) {
        require(__DIR__ . "/config.local.php");
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
?>
