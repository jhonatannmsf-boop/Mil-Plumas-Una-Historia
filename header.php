<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mil Plumas, Una Historia</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="libro-marco">
    <nav class="level mb-5">
        <div class="level-left">
            <a href="index.php" class="logo-titulo">Mil Plumas, Una Historia</a>
        </div>
        <div class="level-item">
            <a href="explorar.php" class="link-cursivo mr-4">Explorar</a>
            <a href="index.php#como-funciona" class="link-cursivo mr-4">Cómo funciona</a>
            <a href="crear.php" class="link-cursivo mr-4">Crear</a>
            <a onclick="history.back()" class="link-cursivo" style="cursor:pointer;">Anterior</a>
        </div>
        <div class="level-right">
            <?php if(isset($_SESSION['usuario'])): ?>
                <a href="perfil.php" class="link-cursivo">@<?php echo $_SESSION['usuario']; ?></a>
            <?php else: ?>
                <a href="login.php" class="link-cursivo mr-3">Iniciar Sesión</a>
                <a href="registro.php" class="link-cursivo">Registrarse</a>
            <?php endif; ?>
        </div>
    </nav>