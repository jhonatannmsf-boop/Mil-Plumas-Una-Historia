function validarCrearHistoria(event) {
    let titulo = document.getElementById("crear-titulo").value.trim();
    let primerCap = document.getElementById("crear-capitulo").value.trim();

    if (!titulo || !primerCap) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Campos Vacíos",
            text: "Todos los campos son obligatorios",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    if (titulo.length < 4) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Título Muy Corto",
            text: "El título debe tener al menos 4 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    let palabras = primerCap.split(/\s+/).filter(Boolean).length;
    if (palabras < 10) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Capítulo Incompleto",
            text: "Escribe al menos 10 palabras para iniciar",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    return true;
}