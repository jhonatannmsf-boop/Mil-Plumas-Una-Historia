<?php
session_start();
require_once('conexion.php');

if (!$conexion) {
    die("Error de conexión a la base de datos");
}

$accion = $_POST['accion'] ?? '';

if ($accion === 'registro') {
    $usuario = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $usuario, $correo, $contrasena);
    
    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $stmt->insert_id;
        $_SESSION['usuario'] = $usuario;
        header("Location: perfil.php");
    } else {
        header("Location: registro.php?error=1");
    }
    $stmt->close();
}

if ($accion === 'login') {
    $usuario = trim($_POST['nombre_usuario']);
    $contrasena = $_POST['contrasena'];

    $stmt = $conexion->prepare("SELECT id, contrasena FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        if (password_verify($contrasena, $fila['contrasena'])) {
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['usuario'] = $usuario;
            header("Location: perfil.php");
        } else {
            header("Location: login.php?error=1");
        }
    } else {
        header("Location: login.php?error=1");
    }
    $stmt->close();
}

if ($accion === 'crear_historia') {
    $titulo = trim($_POST['titulo']);
    $genero = trim($_POST['genero']);
    $tiempo = intval($_POST['tiempo']);
    $limite = intval($_POST['limite']);
    $primer_capitulo = trim($_POST['primer_capitulo']);
    $creador_id = $_SESSION['usuario_id'] ?? 1;

    $stmt = $conexion->prepare("INSERT INTO historias (titulo, genero, tiempo_horas, limite_palabras, creador_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $titulo, $genero, $tiempo, $limite, $creador_id);
    
    if ($stmt->execute()) {
        $historia_id = $stmt->insert_id;
        $stmt_cap = $conexion->prepare("INSERT INTO capitulos (historia_id, usuario_id, numero_turno, contenido) VALUES (?, ?, 1, ?)");
        $stmt_cap->bind_param("iis", $historia_id, $creador_id, $primer_capitulo);
        $stmt_cap->execute();
        $stmt_cap->close();

        header("Location: explorar.php");
    } else {
        header("Location: crear.php?error=1");
    }
    $stmt->close();
}

if ($accion === 'publicar_capitulo') {
    $historia_id = intval($_POST['historia_id']);
    $contenido = trim($_POST['contenido']);
    $usuario_id = $_SESSION['usuario_id'] ?? 1;

    $stmt_turno = $conexion->prepare("SELECT COUNT(*) as total FROM capitulos WHERE historia_id = ?");
    $stmt_turno->bind_param("i", $historia_id);
    $stmt_turno->execute();
    $res = $stmt_turno->get_result()->fetch_assoc();
    $siguiente_turno = $res['total'] + 1;
    $stmt_turno->close();

    $stmt = $conexion->prepare("INSERT INTO capitulos (historia_id, usuario_id, numero_turno, contenido) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $historia_id, $usuario_id, $siguiente_turno, $contenido);
    $stmt->execute();
    $stmt->close();

    require_once('ia_resumen.php');

    $stmt_textos = $conexion->prepare("SELECT contenido FROM capitulos WHERE historia_id = ? ORDER BY numero_turno ASC");
    $stmt_textos->bind_param("i", $historia_id);
    $stmt_textos->execute();
    $res_textos = $stmt_textos->get_result();

    $textoCompleto = "";
    while ($row = $res_textos->fetch_assoc()) {
        $textoCompleto .= " " . $row['contenido'];
    }
    $stmt_textos->close();

    $nuevoResumen = generarResumenIA($textoCompleto);

    $stmt_update = $conexion->prepare("UPDATE historias SET resumen = ? WHERE id = ?");
    $stmt_update->bind_param("si", $nuevoResumen, $historia_id);
    $stmt_update->execute();
    $stmt_update->close();

    header("Location: detalle.php?id=" . $historia_id . "&turno_exito=" . $siguiente_turno);
    exit();
}

$conexion->close();
?>