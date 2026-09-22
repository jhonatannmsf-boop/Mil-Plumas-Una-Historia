<?php 
include('header.php'); 

$historias_bd = [];
if ($conexion) {
    $resH = $conexion->query("
        SELECT h.id, h.titulo, h.genero, h.limite_palabras,
               COUNT(c.id) as total_turnos
        FROM historias h
        LEFT JOIN capitulos c ON h.id = c.historia_id
        GROUP BY h.id
        ORDER BY h.id ASC
    ");
    if ($resH) {
        while ($h = $resH->fetch_assoc()) {
            $historias_bd[] = $h;
        }
    }
}
?>

<input class="input input-estilo mb-4" type="text" placeholder="Buscar Libros o géneros...">
<div class="is-flex is-justify-content-space-between mb-5 px-5">
    <a href="#" class="link-cursivo">Todos</a>
    <a href="#" class="link-cursivo">Fantasía</a>
    <a href="#" class="link-cursivo">Misterio</a>
    <a href="#" class="link-cursivo">Terror</a>
</div>

<div class="columns is-multiline">
    <?php if (!empty($historias_bd)): ?>
        <?php foreach ($historias_bd as $h): ?>
            <div class="column is-4">
                <div class="tarjeta-libro" onclick="location.href='detalle.php?id=<?php echo $h['id']; ?>'" style="cursor:pointer;">
                    <div class="portada-simulada"></div>
                    <div class="link-cursivo is-size-4"><?php echo htmlspecialchars($h['titulo']); ?></div>
                    <div class="link-cursivo is-size-5"><?php echo htmlspecialchars($h['genero']); ?></div>
                    <div class="my-2">👥 <?php echo $h['total_turnos']; ?> turnos escritos</div>
                    <span class="tag tag-turno">Turno #<?php echo ($h['total_turnos'] + 1); ?> Libre • ¡Escribe ahora!</span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="column is-4">
            <div class="tarjeta-libro" onclick="location.href='detalle.php?id=1&titulo=Secretos de Blackwood&genero=Misterio - Terror'" style="cursor:pointer;">
                <div class="portada-simulada"></div>
                <div class="link-cursivo is-size-4">Secretos de Blackwood</div>
                <div class="link-cursivo is-size-5">Misterio • Terror</div>
                <div class="my-2">👤 👤 👤</div>
                <span class="tag tag-turno">Turno Libre • ¡Escribe ahora!</span>
            </div>
        </div>
        <div class="column is-4">
            <div class="tarjeta-libro" onclick="location.href='detalle.php?titulo=Las Sombras del Reloj&genero=Misterio'" style="cursor:pointer;">
                <div class="portada-simulada"></div>
                <div class="link-cursivo is-size-4">Las Sombras del Reloj</div>
                <div class="link-cursivo is-size-5">Misterio</div>
                <div class="my-2">👤 👤 👤</div>
                <span class="tag tag-turno">Turno Libre • ¡Escribe ahora!</span>
            </div>
        </div>
        <div class="column is-4">
            <div class="tarjeta-libro" onclick="location.href='detalle.php?titulo=El Pacto de los Inmortales&genero=Terror - Fantasía'" style="cursor:pointer;">
                <div class="portada-simulada"></div>
                <div class="link-cursivo is-size-4">El Pacto de los Inmortales</div>
                <div class="link-cursivo is-size-5">Terror • Fantasía</div>
                <div class="my-2">👤 👤 👤</div>
                <span class="tag tag-turno">Turno Libre • ¡Escribe ahora!</span>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>