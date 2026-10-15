function validarLogin(event) {
    if (event) event.preventDefault();
    let usuario = document.getElementById("login-usuario").value.trim();
    let pass = document.getElementById("login-pass").value;

    if (usuario === "" || pass === "") {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Campos Vacíos",
            text: "Por favor ingresa tu usuario y contraseña",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    localStorage.setItem('sesionIniciada', 'true');
    localStorage.setItem('usuarioNombre', usuario);
    localStorage.setItem('usuario_activo', usuario);

    Swal.fire({
        position: "center",
        icon: "success",
        title: "¡Bienvenido!",
        text: `Has iniciado sesión correctamente como ${usuario}.`,
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        window.location.href = "explorar.html";
    });

    return false;
}

const formLogin = document.getElementById("form-login");
if (formLogin) {
    formLogin.addEventListener("submit", validarLogin);
}

const btnIniciarSesion = document.getElementById("iniciar_sesion");
if (btnIniciarSesion) {
    btnIniciarSesion.addEventListener("click", validarLogin);
}