function validarRegistro(event) {
    let usuario = document.getElementById("reg-usuario").value.trim();
    let correo = document.getElementById("reg-correo").value.trim();
    let pass = document.getElementById("reg-pass").value;

    let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!usuario || !correo || !pass) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Campos Vacíos",
            text: "Por favor llena todos los campos",
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
            title: "Usuario Inválido",
            text: "El usuario debe tener al menos 3 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    if (!regexCorreo.test(correo)) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Correo Inválido",
            text: "Ingresa un correo electrónico válido",
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
            title: "Contraseña Corta",
            text: "La contraseña debe tener al menos 8 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    return true;
}