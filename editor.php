<?php include('header.php'); ?>

<div class="barra-editor is-flex is-justify-content-space-between mb-4">
    <span>Secretos de Blackwood - Capítulo 4</span>
    <span>⏱️ Tiempo por turnos: 01:45:20</span>
    <span id="contador-palabras">0 / 500 palabras</span>
</div>
<form action="procesar.php" method="POST">
    <input type="hidden" name="accion" value="publicar_capitulo">
    <input type="hidden" name="historia_id" value="1">
    <div class="columns">
        <div class="column is-6">
            <div class="caja-editor">
                <h3 class="link-cursivo is-size-4 mb-2">Resumen de los capítulos anteriores</h3>
                <p class="is-size-7">Capítulo 1: Emma llega a Blackwood y encuentra la casa vieja cerrada con llave...</p>
            </div>
        </div>
        <div class="column is-6">
            <div class="caja-editor">
                <textarea id="texto-capitulo" name="contenido" class="textarea textarea-estilo" style="height:220px; resize:none;" oninput="actualizarContador()" placeholder="Escribe aquí tu contribución al capítulo..." required></textarea>
                <div class="is-flex is-justify-content-space-between mt-3">
                    <button type="button" class="button btn-verde-suave">Guardar Borrador</button>
                    <button type="submit" class="button btn-principal">Publicar y pasar turno</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function actualizarContador() {
    const texto = document.getElementById('texto-capitulo').value.trim();
    const palabras = texto ? texto.split(/\s+/).length : 0;
    document.getElementById('contador-palabras').innerText = palabras + ' / 500 palabras';
}
</script>

<?php include('footer.php'); ?>