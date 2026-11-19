<?php

session_start();

ob_start();
require_once("conexion.php");
ob_end_clean();

header("Content-Type: application/json");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Debes iniciar sesión para tomar un turno"]);
    exit();
}

$id_usuario = (int) $_SESSION['id_usuario'];
$id_historia = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id_historia']) ? (int) $_POST['id_historia'] : 0);

if ($id_historia <= 0) {
    echo json_encode(["error" => "Historia no válida"]);
    exit();
}

$sqlHistoria = "SELECT id_historia, titulo, limite_palabras, tiempo_horas_turno 
                FROM historia 
                WHERE id_historia = '$id_historia'";
$resHistoria = $conn->query($sqlHistoria);

if ($resHistoria->num_rows == 0) {
    echo json_encode(["error" => "La historia no existe"]);
    exit();
}

$historia = $resHistoria->fetch_assoc();
$tiempo_minutos = (int) $historia['tiempo_horas_turno'];
if ($tiempo_minutos <= 0) {
    $tiempo_minutos = 30;
}
$limite_segundos = $tiempo_minutos * 60;

$sqlTurno = "SELECT p.id_usuario, u.nombre_usuario, p.fecha_union,
                    TIMESTAMPDIFF(SECOND, p.fecha_union, NOW()) AS segundos_transcurridos
             FROM participacion p
             INNER JOIN usuario u ON u.id_usuario = p.id_usuario
             WHERE p.id_historia = '$id_historia' AND p.es_turno_actual = 1";
$resTurno = $conn->query($sqlTurno);

if ($resTurno && $resTurno->num_rows > 0) {
    $turnoActual = $resTurno->fetch_assoc();
    $segundos_transcurridos = max(0, (int) $turnoActual['segundos_transcurridos']);

    if ($segundos_transcurridos < $limite_segundos) {
        if ((int) $turnoActual['id_usuario'] !== $id_usuario) {
            $minRestantes = max(1, ceil(($limite_segundos - $segundos_transcurridos) / 60));
            echo json_encode([
                "error" => "Esta historia está siendo editada por " . $turnoActual['nombre_usuario'] . ". Tiempo restante aprox: " . $minRestantes . " min."
            ]);
            exit();
        } else {
            $segundos_restantes = max(1, $limite_segundos - $segundos_transcurridos);
            echo json_encode([
                "ok" => true,
                "titulo" => $historia['titulo'],
                "limite_palabras" => (int) $historia['limite_palabras'],
                "segundos_restantes" => $segundos_restantes
            ]);
            exit();
        }
    } else {
        $conn->query("UPDATE participacion SET es_turno_actual = 0 WHERE id_historia = '$id_historia'");
    }
}

$conn->query("UPDATE participacion SET es_turno_actual = 0 WHERE id_historia = '$id_historia'");

$sqlAsignar = "INSERT INTO participacion (id_usuario, id_historia, orden_turno, es_turno_actual, fecha_union)
               VALUES ('$id_usuario', '$id_historia', 1, 1, NOW())
               ON DUPLICATE KEY UPDATE es_turno_actual = 1, fecha_union = NOW()";
$conn->query($sqlAsignar);

echo json_encode([
    "ok" => true,
    "titulo" => $historia['titulo'],
    "limite_palabras" => (int) $historia['limite_palabras'],
    "segundos_restantes" => $limite_segundos
]);

?>
