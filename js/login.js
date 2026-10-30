function validarLogin(event) {
    let usuario = document.getElementById("login-usuario").value.trim();
    let pass = document.getElementById("login-pass").value;

    if (usuario === "" || pass === "") {
        if (event) event.preventDefault();
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
    if (usuario.length < 3) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Datos Inválidos",
            text: "El usuario debe tener al menos 3 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }
    if (pass.length < 8) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Datos Inválidos",
            text: "La contraseña debe tener al menos 8 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }
    return true;
}

document.getElementById("iniciar_sesion").onclick = validarLogin;
