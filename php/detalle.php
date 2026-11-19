<?php

session_start();

ob_start();
require_once("conexion.php");
ob_end_clean();

header("Content-Type: application/json");

$id_historia = (int) $_GET['id'];

$sql = "SELECT id_historia, titulo, genero, primer_capitulo, limite_palabras, id_usuario_creador, tiempo_horas_turno
        FROM historia
        WHERE id_historia = '$id_historia'";

$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
    echo json_encode(["error" => "La historia no existe"]);
    exit();
}

$historia = $resultado->fetch_assoc();

// Verificar si el usuario en sesión es el creador de la historia
$es_creador = false;
if (isset($_SESSION['id_usuario']) && $historia['id_usuario_creador'] !== null) {
    $es_creador = ((int) $historia['id_usuario_creador'] === (int) $_SESSION['id_usuario']);
}
$historia['es_creador'] = $es_creador;

// Quitar id_usuario_creador para no exponerlo en la respuesta JSON
unset($historia['id_usuario_creador']);

// Verificar estado del turno actual en participacion
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

$turno_info = [
    "activo" => false,
    "es_mi_turno" => false,
    "nombre_usuario" => null,
    "segundos_restantes" => 0
];

if ($resTurno && $resTurno->num_rows > 0) {
    $turnoActual = $resTurno->fetch_assoc();
    $segundos_transcurridos = (int) $turnoActual['segundos_transcurridos'];

    if ($segundos_transcurridos < $limite_segundos) {
        $turno_info["activo"] = true;
        $turno_info["nombre_usuario"] = $turnoActual['nombre_usuario'];
        $turno_info["segundos_restantes"] = $limite_segundos - $segundos_transcurridos;
        if (isset($_SESSION['id_usuario']) && (int) $_SESSION['id_usuario'] === (int) $turnoActual['id_usuario']) {
            $turno_info["es_mi_turno"] = true;
        }
    } else {
        // El tiempo expiró, liberar turno en la base de datos
        $conn->query("UPDATE participacion SET es_turno_actual = 0 WHERE id_historia = '$id_historia'");
    }
}

$historia['turno_actual'] = $turno_info;

$sql = "SELECT capitulo.id_capitulo, capitulo.numero_turno, capitulo.contenido, usuario.nombre_usuario
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
