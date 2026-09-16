<?php include('header.php'); ?>

<div class="columns is-centered">
    <div class="column is-8">
        <div class="caja-verde-formulario has-text-centered">
            <h2 class="hero-titulo is-size-2 mb-3">Crear Nueva Historia / Nuevo libro</h2>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="accion" value="crear_historia">
                <div class="field has-text-left mb-3">
                    <label class="label label-cursivo">Título de la historia</label>
                    <input class="input input-estilo" type="text" name="titulo" placeholder="Título de la historia" required>
                </div>
                <div class="field has-text-left mb-3">
                    <label class="label label-cursivo">Género</label>
                    <div class="control">
                        <input class="input input-estilo" type="text" name="genero" value="Fantasía" placeholder="Fantasía, Misterio, Terror..." required>
                    </div>
                </div>
                <div class="field has-text-left mb-3">
                    <label class="label label-cursivo">Configuración de Reglas (Horas / Máx Palabras)</label>
                    <div class="columns">
                        <div class="column is-6"><input class="input input-estilo" type="number" name="tiempo" value="24"></div>
                        <div class="column is-6"><input class="input input-estilo" type="number" name="limite" value="300"></div>
                    </div>
                </div>
                <div class="field has-text-left mb-4">
                    <label class="label label-cursivo">Primer capítulo / inicio de la historia</label>
                    <textarea class="textarea textarea-estilo" name="primer_capitulo" rows="3" required></textarea>
                </div>
                <button type="submit" class="button btn-verde-suave px-5">Publicar e Iniciar Historia</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>