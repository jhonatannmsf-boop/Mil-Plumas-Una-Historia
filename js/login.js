function validarLogin(event) {
    event.preventDefault();
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
    } else {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "¡Bienvenido!",
            text: "Has iniciado sesión correctamente.",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = "explorar.html";
        });
        return true;
    }
}

document.getElementById("iniciar_sesion").onclick = validarLogin;