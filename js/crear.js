function validarCrearHistoria() {
    let titulo = document.getElementById("crear_titulo").value.trim();
    let primerCap = document.getElementById("crear_primer_capitulo").value.trim();
    let genero = document.getElementById("crear_genero").value.trim();

    if (!titulo || !primerCap || !genero) {
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

    let generoValido = ["aventura", "romance", "fantasía", "ciencia ficción", "terror"];
    if (!generoValido.includes(genero.toLowerCase())) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Género Inválido",
            text: "Selecciona un género válido de la lista",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    return true;        
}

function procesarCrearHistoria(event) {
    if (event) event.preventDefault();
    if (!validarCrearHistoria()) return false;

    Swal.fire({
        icon: "success",
        title: "¡Historia Creada!",
        text: "Tu nueva historia ha sido creada con éxito.",
        confirmButtonColor: '#5b8c60'
    }).then(() => {
        window.location.href = "explorar.html";
    });

    return false;
}
