<?php 
include('header.php'); 

$historia_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$param_titulo = $_GET['titulo'] ?? '';

$historia = null;
if ($conexion) {
    if ($historia_id > 0) {
        $stmt = $conexion->prepare("SELECT * FROM historias WHERE id = ?");
        $stmt->bind_param("i", $historia_id);
        $stmt->execute();
        $historia = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    } elseif (!empty($param_titulo)) {
        $stmt = $conexion->prepare("SELECT * FROM historias WHERE titulo = ? LIMIT 1");
        $stmt->bind_param("s", $param_titulo);
        $stmt->execute();
        $historia = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

    if (!$historia) {
        $res = $conexion->query("SELECT * FROM historias ORDER BY id ASC LIMIT 1");
        if ($res && $res->num_rows > 0) {
            $historia = $res->fetch_assoc();
        }
    }
}

if (!$historia) {
    $historia = [
        'id' => 1,
        'titulo' => !empty($param_titulo) ? $param_titulo : 'Secretos de Blackwood',
        'genero' => $_GET['genero'] ?? 'Misterio - Terror',
        'limite_palabras' => 300,
        'resumen' => 'En Blackwood, los secretos nunca mueren. Después de años lejos de casa, Emma regresa al viejo pueblo. Todo parece igual... hasta que comienzan a ocurrir cosas extrañas y una serie de desapariciones despierta viejas historias que nadie quiere recordar.'
    ];
}

$historia_id = $historia['id'];
$titulo = $historia['titulo'];
$genero = $historia['genero'];
$limite_palabras = $historia['limite_palabras'] ?? 300;
$descripcion = !empty($historia['resumen']) ? $historia['resumen'] : "En Blackwood, los secretos nunca mueren. Después de años lejos de casa, Emma regresa al viejo pueblo.";

$capitulos = [];
if ($conexion) {
    $stmt = $conexion->prepare("
        SELECT c.id, c.numero_turno, c.contenido, c.fecha_creacion, 
               COALESCE(u.nombre_usuario, 'Escritor anónimo') AS autor
        FROM capitulos c
        LEFT JOIN usuarios u ON c.usuario_id = u.id
        WHERE c.historia_id = ?
        ORDER BY c.numero_turno ASC
    ");
    if ($stmt) {
        $stmt->bind_param("i", $historia_id);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $capitulos[] = $row;
        }
        $stmt->close();
    }
}

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
$proximo_turno = $total_turnos + 1;
?>

<div class="columns">
    <div class="column is-7">
        <div class="caja-detalle-izq">
            <h2 class="hero-titulo is-size-2"><?php echo htmlspecialchars($titulo); ?></h2>
            <p class="link-cursivo is-size-4"><?php echo htmlspecialchars($genero); ?></p>
            <p class="mt-3 is-size-6" style="line-height: 1.6; text-align: justify;">
                <?php echo htmlspecialchars($desfcripcion); ?>
            </p>
            <div class="tag tag-turno mt-4 p-3">
                Reglas: Máx. <?php echo htmlspecialchars($limite_palabras); ?> palabras por turno • Turnos completados: <?php echo $total_turnos; ?>
            </div>
        </div>
    </div>

    <div class="column is-5 has-text-centered">
        <h3 class="link-cursivo is-size-3">¡Turno #<?php echo $proximo_turno; ?> disponible! Escribe</h3>
        <a href="editor.php?id=<?php echo $historia_id; ?>&turno=<?php echo $proximo_turno; ?>" class="button btn-principal my-3">
            Tomar Turno #<?php echo $proximo_turno; ?> y escribir
        </a>

        <div class="linea-tiempo-caja mt-3">
            <h4 class="link-cursivo is-size-4 mb-2">📜 Turnos de la Historia (Toca para leer)</h4>
            <p class="is-size-7 mb-3" style="color: #1b261b;">Toca cualquiera de los turnos para ver quién lo escribió y su texto completo:</p>
            
            <div class="lista-turnos-scroll">
                <?php foreach ($capitulos as $cap): ?>
                    <div class="item-linea-tiempo item-turno-interactivo" 
                         onclick="verTurno(<?php echo $cap['numero_turno']; ?>, <?php echo htmlspecialchars(json_encode($cap['autor'])); ?>, <?php echo htmlspecialchars(json_encode($cap['contenido'])); ?>)"
                         role="button"
                         tabindex="0"
                         title="Toca para ver el contenido del Turno <?php echo $cap['numero_turno']; ?>">
                        <div class="is-flex is-justify-content-space-between is-align-items-center">
                            <span>📖 <strong>Turno <?php echo $cap['numero_turno']; ?>:</strong> @<?php echo htmlspecialchars($cap['autor']); ?></span>
                            <span class="tag-leer-turno">👁️ Ver</span>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="item-linea-tiempo item-proximo-turno">
                    <span>✨ <strong>Turno <?php echo $proximo_turno; ?>:</strong> (¡Tu turno disponible para escribir!)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function verTurno(numeroTurno, autor, contenido) {
    Swal.fire({
        title: `<span class="link-cursivo" style="font-size: 30px;">Turno #${numeroTurno}</span>`,
        html: `
            <div style="text-align: left; background-color: #f3faf4; padding: 18px; border-radius: 20px; border: 2px solid #9acb9e; max-height: 380px; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #c1dec4; padding-bottom: 8px;">
                    <span style="font-size: 17px; font-weight: bold; color: #1b261b;">
                        ✍️ Escrito por: <span style="color: #2e6235;">@${autor}</span>
                    </span>
                    <span style="font-size: 13px; color: #4a674e; background-color: #d7edd9; padding: 3px 10px; border-radius: 12px;">
                        Capítulo / Turno #${numeroTurno}
                    </span>
                </div>
                <div style="font-size: 16px; line-height: 1.7; color: #233123; white-space: pre-line; text-align: justify;">
                    ${contenido}
                </div>
            </div>
        `,
        confirmButtonText: 'Cerrar lectura',
        confirmButtonColor: '#5b8c60',
        background: '#eaf4eb',
        customClass: {
            popup: 'modal-lectura-estilo'
        }
    });
}

<?php if (isset($_GET['turno_exito'])): ?>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<span class="link-cursivo is-size-2">¡Turno Publicado!</span>',
        html: '<p class="is-size-5">Has completado el <strong>Turno #<?php echo intval($_GET['turno_exito']); ?></strong> con éxito.<br>Tu contribución ya aparece en la línea de tiempo y la pluma pasa al siguiente escritor.</p>',
        icon: 'success',
        confirmButtonText: '¡Genial!',
        confirmButtonColor: '#5b8c60'
    });
});
<?php endif; ?>
</script>

<?php include('footer.php'); ?>