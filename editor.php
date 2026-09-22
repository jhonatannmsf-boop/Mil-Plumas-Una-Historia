<?php 
include('header.php');

// Obtener la historia de la BD
$historia_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$historia = null;
if ($conexion) {
    $stmt = $conexion->prepare("SELECT id, titulo, genero, limite_palabras, resumen FROM historias WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $historia_id);
        $stmt->execute();
        $historia = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
}

// Fallback seguro si la historia no existe en la BD
if (!$historia) {
    $historia = [
        'id' => $historia_id,
        'titulo' => 'Secretos de Blackwood',
        'genero' => 'Misterio - Terror',
        'limite_palabras' => 300,
        'resumen' => 'Emma regresa a Blackwood tras años de ausencia. Una serie de extrañas desapariciones y susurros nocturnos amenazan con desvelar los oscuros secretos del pueblo.'
    ];
}

$limitePalabras = intval($historia['limite_palabras'] ?? 300);
$resumenTexto = !empty($historia['resumen']) ? $historia['resumen'] : "Aún no se ha generado un resumen para esta historia.";

// Consultar los turnos/capítulos anteriores
$capitulos = [];
if ($conexion) {
    $stmt_caps = $conexion->prepare("
        SELECT c.id, c.numero_turno, c.contenido, c.fecha_creacion,
               COALESCE(u.nombre_usuario, 'Escritor anónimo') AS autor
        FROM capitulos c
        LEFT JOIN usuarios u ON c.usuario_id = u.id
        WHERE c.historia_id = ?
        ORDER BY c.numero_turno ASC
    ");
    if ($stmt_caps) {
        $stmt_caps->bind_param("i", $historia_id);
        $stmt_caps->execute();
        $res_caps = $stmt_caps->get_result();
        while ($row = $res_caps->fetch_assoc()) {
            $capitulos[] = $row;
        }
        $stmt_caps->close();
    }
}

// Respaldo de turnos si no hay en la BD
if (empty($capitulos)) {
    $capitulos = [
        [
            'numero_turno' => 1,
            'autor' => 'Emma',
            'contenido' => 'En Blackwood, los secretos nunca mueren. Después de años lejos de casa, Emma regresa al viejo pueblo. Todo parece igual... hasta que comienzan a ocurrir cosas extrañas y una serie de desapariciones despierta viejas historias que nadie quiere recordar.'
        ],
        [
            'numero_turno' => 2,
            'autor' => 'Dino',
            'contenido' => 'La niebla cubrió las calles empedradas al caer la noche. Frente al farol apagado, Emma juró escuchar pasos apresurados detrás de ella. Se dio la vuelta con el corazón palpitando, pero solo encontró una vieja pluma negra en el suelo húmedo.'
        ],
        [
            'numero_turno' => 3,
            'autor' => 'Sofia',
            'contenido' => 'Al levantar la pluma, un escalofrío recorrió su espalda. Las campanas de la iglesia abandonada comenzaron a doblar a deshoras, resonando con un eco ensordecedor que parecía llamarla por su nombre desde las sombras.'
        ]
    ];
}

$total_turnos = count($capitulos);
$numero_turno = $total_turnos + 1;
?>

<!-- Barra superior del Editor: Informa claramente el Turno Actual -->
<div class="barra-editor is-flex is-justify-content-space-between is-align-items-center mb-4">
    <span class="is-size-5 font-weight-bold">📖 <?php echo htmlspecialchars($historia['titulo']); ?></span>
    <span class="badge-tu-turno">✍️ Tu Turno: <strong>Turno #<?php echo $numero_turno; ?></strong> (¡Te toca escribir!)</span>
    <span id="contador-palabras">0 / <?php echo $limitePalabras; ?> palabras</span>
</div>

<form action="procesar.php" method="POST">
    <input type="hidden" name="accion" value="publicar_capitulo">
    <input type="hidden" name="historia_id" value="<?php echo $historia['id']; ?>">
    <input type="hidden" name="numero_turno" value="<?php echo $numero_turno; ?>">
    
    <div class="columns">
        <!-- Columna Izquierda: Resumen IA y Consulta de Turnos Anteriores -->
        <div class="column is-6">
            <div class="caja-editor">
                <!-- Pestañas para alternar entre Resumen y Turnos Anteriores -->
                <div class="pestanas-editor mb-3">
                    <button type="button" id="btn-tab-resumen" class="btn-tab is-active" onclick="cambiarTabEditor('resumen')">
                        🤖 Resumen IA
                    </button>
                    <button type="button" id="btn-tab-turnos" class="btn-tab" onclick="cambiarTabEditor('turnos')">
                        📜 Turnos Anteriores (<?php echo $total_turnos; ?>)
                    </button>
                </div>

                <!-- Panel 1: Resumen IA -->
                <div id="panel-resumen">
                    <h3 class="link-cursivo is-size-4 mb-2">Resumen de los capítulos anteriores</h3>
                    <p class="is-size-7" style="line-height: 1.6; text-align: justify;">
                        <?php echo htmlspecialchars($resumenTexto); ?>
                    </p>
                </div>

                <!-- Panel 2: Turnos Anteriores con lectura al tocar -->
                <div id="panel-turnos" style="display: none;">
                    <h3 class="link-cursivo is-size-4 mb-2">Turnos Anteriores (Toca para leer)</h3>
                    <p class="is-size-7 mb-2">Toca cualquier turno para leer lo que escribió ese autor:</p>
                    <div class="lista-turnos-editor">
                        <?php foreach ($capitulos as $cap): ?>
                            <div class="item-linea-tiempo item-turno-interactivo mb-2"
                                 onclick="verTurnoEditor(<?php echo $cap['numero_turno']; ?>, <?php echo htmlspecialchars(json_encode($cap['autor'])); ?>, <?php echo htmlspecialchars(json_encode($cap['contenido'])); ?>)">
                                <div class="is-flex is-justify-content-space-between is-align-items-center">
                                    <span>📖 <strong>Turno <?php echo $cap['numero_turno']; ?>:</strong> @<?php echo htmlspecialchars($cap['autor']); ?></span>
                                    <span class="tag-leer-turno">👁️ Ver texto</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Columna Derecha: Editor de texto -->
        <div class="column is-6">
            <div class="caja-editor">
                <div class="aviso-turno-editor mb-2">
                    ✍️ <strong>Turno #<?php echo $numero_turno; ?>:</strong> Escribe tu contribución para continuar el relato (mín. 10 palabras, máx. <?php echo $limitePalabras; ?> palabras).
                </div>
                <textarea id="texto-capitulo" 
                          name="contenido" 
                          class="textarea textarea-estilo" 
                          style="height:210px; resize:none;" 
                          data-limite="<?php echo $limitePalabras; ?>"
                          data-turno="<?php echo $numero_turno; ?>"
                          oninput="actualizarContador()" 
                          placeholder="Escribe aquí el Turno #<?php echo $numero_turno; ?> de la historia..." 
                          required></textarea>

                <div class="is-flex is-justify-content-space-between mt-3">                  
                    <button type="button" onclick="guardarBorrador()" class="button btn-verde-suave">Guardar Borrador</button>
                    <button type="submit" onclick="return validarEditor(event)" class="button btn-principal">
                        Publicar Turno #<?php echo $numero_turno; ?> y pasar pluma
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Alternar pestañas en el editor
function cambiarTabEditor(tab) {
    const pResumen = document.getElementById('panel-resumen');
    const pTurnos = document.getElementById('panel-turnos');
    const bResumen = document.getElementById('btn-tab-resumen');
    const bTurnos = document.getElementById('btn-tab-turnos');

    if (tab === 'resumen') {
        pResumen.style.display = 'block';
        pTurnos.style.display = 'none';
        bResumen.classList.add('is-active');
        bTurnos.classList.remove('is-active');
    } else {
        pResumen.style.display = 'none';
        pTurnos.style.display = 'block';
        bTurnos.classList.add('is-active');
        bResumen.classList.remove('is-active');
    }
}

// Ver lo que escribió cada persona desde el editor
function verTurnoEditor(numeroTurno, autor, contenido) {
    Swal.fire({
        title: `<span class="link-cursivo" style="font-size: 28px;">Turno #${numeroTurno}</span>`,
        html: `
            <div style="text-align: left; background-color: #f3faf4; padding: 16px; border-radius: 18px; border: 2px solid #9acb9e; max-height: 320px; overflow-y: auto;">
                <p style="font-weight: bold; margin-bottom: 8px; color: #1b261b;">
                    ✍️ Escrito por: <span style="color: #2e6235;">@${autor}</span>
                </p>
                <hr style="margin: 8px 0; background-color: #c1dec4;">
                <p style="font-size: 15px; line-height: 1.6; color: #233123; white-space: pre-line; text-align: justify;">
                    ${contenido}
                </p>
            </div>
        `,
        confirmButtonText: 'Volver al editor',
        confirmButtonColor: '#5b8c60',
        background: '#eaf4eb'
    });
}

function guardarBorrador() {
    const texto = document.getElementById("texto-capitulo").value;
    if (!texto.trim()) {
        Swal.fire({
            icon: 'info',
            title: 'Borrador vacío',
            text: 'Escribe algo primero antes de guardar tu borrador.',
            confirmButtonColor: '#5b8c60'
        });
        return;
    }
    localStorage.setItem('borrador_historia_<?php echo $historia_id; ?>', texto);
    Swal.fire({
        icon: 'success',
        title: 'Borrador guardado',
        text: 'Tu texto se guardó localmente en este navegador.',
        timer: 1500,
        showConfirmButton: false
    });
}

// Recuperar borrador si existe
document.addEventListener('DOMContentLoaded', function() {
    const guardado = localStorage.getItem('borrador_historia_<?php echo $historia_id; ?>');
    const textarea = document.getElementById("texto-capitulo");
    if (guardado && textarea && !textarea.value) {
        textarea.value = guardado;
        if (typeof actualizarContador === 'function') {
            actualizarContador();
        }
    }
});
</script>

<?php include('footer.php'); ?>