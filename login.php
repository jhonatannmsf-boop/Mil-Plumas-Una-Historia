<?php include('header.php'); ?>

<div class="columns is-centered">
    <div class="column is-6">
        <div class="caja-verde-formulario has-text-centered">
            <h2 class="hero-titulo is-size-2 mb-4">Inicio De Sesion</h2>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="accion" value="login">
                <div class="field has-text-left mb-3">
                    <label class="label label-cursivo">Usuario *</label>
                    <div class="control">
                        <input id="login-usuario" class="input input-estilo" type="text" name="nombre_usuario" placeholder="Ingresa tu nombre de usuario" required>
                    </div>
                </div>
                <div class="field has-text-left mb-4">
                    <label class="label label-cursivo">Contraseña *</label>
                    <div class="control">
                        <input id="login-pass" class="input input-estilo" type="password" name="contrasena" placeholder="Ingresa tu contraseña" required>
                    </div>
                </div>
                <button type="submit" onclick="return validarLogin(event)" class="btn btn-primario">Iniciar Sesión</button>
                <a href="registro.php" class="is-block mt-3 link-cursivo is-size-5">¿No tienes una cuenta?</a>
            </form>
            <script src="js/login.js"></script>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>