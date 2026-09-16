<?php 
include('header.php'); 
$titulo = $_GET['titulo'] ?? 'Secretos de Blackwood';
$genero = $_GET['genero'] ?? 'Misterio - Terror';
?>

<div class="columns">
    <div class="column is-7">
        <div class="caja-detalle-izq">
            <h2 class="hero-titulo is-size-2"><?php echo htmlspecialchars($titulo); ?></h2>
            <p class="link-cursivo is-size-4"><?php echo htmlspecialchars($genero); ?></p>
            <p class="mt-3 is-size-6">
                En Blackwood, los secretos nunca mueren. Después de años lejos de casa, Emma regresa al viejo pueblo. Todo parece igual... hasta que comienzan a ocurrir cosas extrañas y una serie de desapariciones despierta viejas historias que nadie quiere recordar.
            </p>
            <div class="tag tag-turno mt-4 p-3">Reglas: Máx. 300 palabras por turno</div>
        </div>
    </div>
    <div class="column is-5 has-text-centered">
        <h3 class="link-cursivo is-size-3">¡Turno disponible! Escribe</h3>
        <a href="editor.php" class="button btn-principal my-3">Tomar turno y escribir</a>
        <div class="linea-tiempo-caja mt-3">
            <h4 class="link-cursivo is-size-4">Línea de Tiempo de Capítulos</h4>
            <div class="item-linea-tiempo">Turno 1:</div>
            <div class="item-linea-tiempo">Turno 2:</div>
            <div class="item-linea-tiempo">Turno 3:</div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>