<?php

if (!isset($conexion) || !($conexion instanceof mysqli)) {
    $host = "localhost";
    $usuario_db = "root";
    $clave_db = "";
    $nombre_db = "mil_plumas";

    try {
        mysqli_report(MYSQLI_REPORT_OFF);
        $conexion = @new mysqli($host, $usuario_db, $clave_db);

        if ($conexion && !$conexion->connect_error) {
            $conexion->query("CREATE DATABASE IF NOT EXISTS `$nombre_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $conexion->select_db($nombre_db);
            $conexion->set_charset("utf8mb4");

            $conexion->query("CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre_usuario VARCHAR(100) NOT NULL UNIQUE,
                correo VARCHAR(150) NOT NULL,
                contrasena VARCHAR(255) NOT NULL,
                fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            $conexion->query("CREATE TABLE IF NOT EXISTS historias (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(255) NOT NULL,
                genero VARCHAR(100) NOT NULL,
                tiempo_horas INT DEFAULT 24,
                limite_palabras INT DEFAULT 300,
                creador_id INT DEFAULT 1,
                resumen TEXT,
                fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            $conexion->query("CREATE TABLE IF NOT EXISTS capitulos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                historia_id INT NOT NULL,
                usuario_id INT DEFAULT 1,
                numero_turno INT NOT NULL,
                contenido TEXT NOT NULL,
                fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            $checkHistorias = $conexion->query("SELECT COUNT(*) as total FROM historias");
            if ($checkHistorias) {
                $fila = $checkHistorias->fetch_assoc();
                if (intval($fila['total']) === 0) {
                    $passDemo = password_hash('12345678', PASSWORD_BCRYPT);
                    $stmtUser = $conexion->prepare("INSERT IGNORE INTO usuarios (id, nombre_usuario, correo, contrasena) VALUES 
                        (1, 'Emma', 'emma@ejemplo.com', ?),
                        (2, 'Dino', 'dino@ejemplo.com', ?),
                        (3, 'Sofia', 'sofia@ejemplo.com', ?)");
                    if ($stmtUser) {
                        $stmtUser->bind_param("sss", $passDemo, $passDemo, $passDemo);
                        $stmtUser->execute();
                        $stmtUser->close();
                    }

                    $resumenInicial = "Emma regresa a Blackwood tras años de ausencia. Una serie de extrañas desapariciones y susurros nocturnos amenazan con desvelar los oscuros secretos del pueblo.";
                    $stmtHist = $conexion->prepare("INSERT INTO historias (id, titulo, genero, tiempo_horas, limite_palabras, creador_id, resumen) VALUES 
                        (1, 'Secretos de Blackwood', 'Misterio - Terror', 24, 300, 1, ?)");
                    if ($stmtHist) {
                        $stmtHist->bind_param("s", $resumenInicial);
                        $stmtHist->execute();
                        $stmtHist->close();
                    }

                    $cap1 = "En Blackwood, los secretos nunca mueren. Después de años lejos de casa, Emma regresa al viejo pueblo. Todo parece igual... hasta que comienzan a ocurrir cosas extrañas y una serie de desapariciones despierta viejas historias que nadie quiere recordar.";
                    $cap2 = "La niebla cubrió las calles empedradas al caer la noche. Frente al farol apagado, Emma juró escuchar pasos apresurados detrás de ella. Se dio la vuelta con el corazón palpitando, pero solo encontró una vieja pluma negra en el suelo húmedo.";
                    $cap3 = "Al levantar la pluma, un escalofrío recorrió su espalda. Las campanas de la iglesia abandonada comenzaron a doblar a deshoras, resonando con un eco ensordecedor que parecía llamarla por su nombre desde las sombras.";

                    $stmtCap = $conexion->prepare("INSERT INTO capitulos (historia_id, usuario_id, numero_turno, contenido) VALUES (?, ?, ?, ?)");
                    if ($stmtCap) {
                        $hId = 1;
                        $u1 = 1; $t1 = 1;
                        $stmtCap->bind_param("iiis", $hId, $u1, $t1, $cap1);
                        $stmtCap->execute();

                        $u2 = 2; $t2 = 2;
                        $stmtCap->bind_param("iiis", $hId, $u2, $t2, $cap2);
                        $stmtCap->execute();

                        $u3 = 3; $t3 = 3;
                        $stmtCap->bind_param("iiis", $hId, $u3, $t3, $cap3);
                        $stmtCap->execute();

                        $stmtCap->close();
                    }
                }
            }
        } else {
            $conexion = null;
        }
    } catch (Throwable $e) {
        $conexion = null;
    }
}
?>
