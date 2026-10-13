function validarEditor(event) {
    event.preventDefault();
    let textarea = document.getElementById("texto_capitulo");
    let contenido = textarea.value.trim();
    let palabras = contenido ? contenido.split(/\s+/).filter(Boolean).length : 0;
    let limite = textarea.dataset.limite ? parseInt(textarea.dataset.limite) : 300;
    

    if (palabras < 10) {
        
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Turno Incompleto",
            text: "Debes escribir al menos 10 palabras antes de publicar tu turno.",
            confirmButtonColor: '#5b8c60'
        });
        return false;
    }

    if (palabras > limite) {
        
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Límite Excedido",
            text: `Has superado el límite de ${limite} palabras permitido para este turno (llevas ${palabras}).`,
            confirmButtonColor: '#5b8c60'
        });
        return false;
    }
    else {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "¡Turno Publicado!",
            text: "Tu contribución ha sido enviada y se pasó la pluma.",
            confirmButtonColor: '#5b8c60'
        }).then(() => {
            window.location.href = "detalle.html";
        });
        return true;
    }
}

function actualizarContador() {
    let textarea = document.getElementById("texto_capitulo");
    if (!textarea) return;

    let contenido = textarea.value.trim();
    let palabras = contenido ? contenido.split(/\s+/).filter(Boolean).length : 0;
    let limite = textarea.dataset.limite ? parseInt(textarea.dataset.limite) : 300;

    let contador = document.getElementById("contador-palabras");
    if (contador) {
        contador.textContent = `${palabras} / ${limite} palabras`;
        if (palabras > limite) {
            contador.style.color = "red";
        } else {
            contador.style.color = "";
        }
    }
}

document.getElementById("publicar_turno").onclick = validarEditor;
