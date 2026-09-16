<?php include('header.php'); ?>

<div class="columns is-centered">
    <div class="column is-6">
        <div class="caja-verde-formulario has-text-centered">
            <h2 class="hero-titulo is-size-2 mb-4">Crear cuenta</h2>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="accion" value="registro">
                <div class="field has-text-left mb-3">
                    <label class="label label-cursivo">Nombre de usuario *</label>
                    <div class="control">
                        <input class="input input-estilo" type="text" name="nombre_usuario" placeholder="Crea tu nombre de usuario" required>
                    </div>
                </div>
                <div class="field has-text-left mb-3">
                    <label class="label label-cursivo">Correo *</label>
                    <div class="control">
                        <input class="input input-estilo" type="email" name="correo" placeholder="ejemplo@gmail.com" required>
                    </div>
                </div>
                <div class="field has-text-left mb-4">
                    <label class="label label-cursivo">Contraseña * (8 caracteres)</label>
                    <div class="control">
                        <input class="input input-estilo" type="password" name="contrasena" placeholder="ejemplo2345@" required>
                    </div>
                </div>
                <button type="submit" class="button btn-verde-suave px-5">Ingresar</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>