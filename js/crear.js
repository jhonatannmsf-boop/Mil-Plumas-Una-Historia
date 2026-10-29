function validarCrearHistoria() {
    let titulo = document.getElementById("crear_titulo").value.trim();
    let primerCap = document.getElementById("crear_primer_capitulo").value.trim();
    let genero = document.getElementById("crear_genero").value.trim();
    let tiempo = document.getElementById("crear_tiempo").value.trim();
    let limite = document.getElementById("crear_limite").value.trim();

    if (!titulo || !primerCap || !genero || !tiempo || !limite) {
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

    if (parseInt(tiempo) <= 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Tiempo Inválido",
            text: "El tiempo por turno debe ser un número positivo",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    if (parseInt(limite) <= 0 || parseInt(limite) > 300) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Límite de Palabras Inválido",
            text: "El límite de palabras debe ser un número positivo y no mayor a 300",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    Swal.fire({
        position: "center",
        icon: "success",
        title: "¡Historia Creada!",
        text: `La historia "${titulo}" ha sido creada exitosamente.`,
        showConfirmButton: false,
        timer: 1500
    });

    return true;
    
}

