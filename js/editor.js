// Validar el formulario antes de enviar
function validarEditor(event) {
    let textarea = document.getElementById("texto-capitulo");
    let contenido = textarea ? textarea.value.trim() : "";
    let palabras = contenido ? contenido.split(/\s+/).filter(Boolean).length : 0;

    if (palabras < 10) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Capítulo Muy Corto",
            text: "Debes escribir al menos 10 palabras antes de publicar.",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    if (palabras > 500) {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Límite Excedido",
            text: "Has superado el límite de 500 palabras por turno.",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }

    return true;
}

// Actualizar el contador de palabras en tiempo real
function actualizarContador() {
    let textarea = document.getElementById("texto-capitulo");
    let contador = document.getElementById("contador-palabras");
    
    if (textarea && contador) {
        let texto = textarea.value.trim();
        // .filter(Boolean) evita contar espacios vacíos extras
        let palabras = texto ? texto.split(/\s+/).filter(Boolean).length : 0; 
        contador.innerText = palabras + " / 500 palabras";
    }
}