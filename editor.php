<?php 
include('header.php');

// Obtener la historia de la BD
$historia_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$consulta = $conexion->query("SELECT titulo, resumen FROM historias WHERE id = '$historia_id'");
$historia = $consulta->fetch_assoc();

$resumenTexto = !empty($historia['resumen']) ? $historia['resumen'] : "Aún no se ha generado un resumen para esta historia.";
?>

<div class="barra-editor is-flex is-justify-content-space-between mb-4">
    <span><?php echo htmlspecialchars($historia['titulo']); ?></span>
    <span>⏱️ Tiempo por turnos: 01:45:20</span>
    <span id="contador-palabras">0 / 500 palabras</span>
</div>

<form action="procesar.php" method="POST">
    <input type="hidden" name="accion" value="publicar_capitulo">
    <input type="hidden" name="historia_id" value="<?php echo $historia_id; ?>">
    
    <div class="columns">
        <!-- Columna Izquierda: Resumen generado por IA de la BD -->
        <div class="column is-6">
            <div class="caja-editor">
                <h3 class="link-cursivo is-size-4 mb-2">Resumen de los capítulos anteriores (IA)</h3>
                <p class="is-size-7" style="line-height: 1.5; text-align: justify;">
                    <?php echo htmlspecialchars($resumenTexto); ?>
                </p>
            </div>
        </div>
        
        <!-- Columna Derecha: Editor de texto -->
        <div class="column is-6">
            <div class="caja-editor">
                <textarea id="texto-capitulo" name="contenido" class="textarea textarea-estilo" style="height:220px; resize:none;" oninput="actualizarContador()" placeholder="Escribe aquí tu contribución al capítulo..." required></textarea>
                <div class="is-flex is-justify-content-space-between mt-3">                  
                    <button type="button" class="button btn-verde-suave">Guardar Borrador</button>
                    <button type="submit" onclick="return validarEditor(event)" class="button btn-principal">Publicar y pasar turno</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="js/editor.js"></script>
<?php include('footer.php'); ?>