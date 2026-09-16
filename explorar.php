<?php include('header.php'); ?>

<input class="input input-estilo mb-4" type="text" placeholder="Buscar Libros o géneros...">
<div class="is-flex is-justify-content-space-between mb-5 px-5">
    <a href="#" class="link-cursivo">Todos</a>
    <a href="#" class="link-cursivo">Fantasía</a>
    <a href="#" class="link-cursivo">Misterio</a>
    <a href="#" class="link-cursivo">Terror</a>
</div>
<div class="columns">
    <div class="column is-4">
        <div class="tarjeta-libro" onclick="location.href='detalle.php?titulo=Las Sombras del Reloj&genero=Misterio'">
            <div class="portada-simulada"></div>
            <div class="link-cursivo is-size-4">Las Sombras del Reloj</div>
            <div class="link-cursivo is-size-5">Misterio</div>
            <div class="my-2">👤 👤 👤</div>
            <span class="tag tag-turno">Turno Libre • ¡Escribe ahora!</span>
        </div>
    </div>
    <div class="column is-4">
        <div class="tarjeta-libro" onclick="location.href='detalle.php?titulo=Secretos de Blackwood&genero=Misterio - Terror'">
            <div class="portada-simulada"></div>
            <div class="link-cursivo is-size-4">Secretos de Blackwood</div>
            <div class="link-cursivo is-size-5">Misterio • Terror</div>
            <div class="my-2">👤 👤 👤</div>
            <span class="tag tag-turno">Turno de @Dino (Escribiendo)</span>
        </div>
    </div>
    <div class="column is-4">
        <div class="tarjeta-libro" onclick="location.href='detalle.php?titulo=El Pacto de los Inmortales&genero=Terror - Fantasía'">
            <div class="portada-simulada"></div>
            <div class="link-cursivo is-size-4">El Pacto de los Inmortales</div>
            <div class="link-cursivo is-size-5">Terror • Fantasía</div>
            <div class="my-2">👤 👤 👤</div>
            <span class="tag tag-turno">Turno Libre • ¡Escribe ahora!</span>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>