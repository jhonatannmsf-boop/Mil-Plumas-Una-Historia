function validarEditor(event) {
    let textarea = document.getElementById("texto-capitulo");
    if (!textarea) return true;

    let contenido = textarea.value.trim();
    let palabras = contenido ? contenido.split(/\s+/).filter(Boolean).length : 0;
    let limite = textarea.dataset.limite ? parseInt(textarea.dataset.limite) : 300;
    let turno = textarea.dataset.turno ? textarea.dataset.turno : "";

    if (palabras < 10) {
        if (event) event.preventDefault();
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
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Límite Excedido",
            text: `Has superado el límite de ${limite} palabras permitido para este turno (llevas ${palabras}).`,
            confirmButtonColor: '#5b8c60'
        });
        return false;
    }

    Swal.fire({
        title: `Publicando Turno #${turno}...`,
        text: 'Guardando tu contribución y pasando la pluma...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    return true;
}

function actualizarContador() {
    let textarea = document.getElementById("texto-capitulo");
    let contador = document.getElementById("contador-palabras");
    
    if (textarea && contador) {
        let texto = textarea.value.trim();
        let palabras = texto ? texto.split(/\s+/).filter(Boolean).length : 0; 
        let limite = textarea.dataset.limite ? parseInt(textarea.dataset.limite) : 300;

        contador.innerText = palabras + " / " + limite + " palabras";

        if (palabras > limite) {
            contador.style.color = "#d9534f";
            contador.style.fontWeight = "bold";
        } else {
            contador.style.color = "";
            contador.style.fontWeight = "";
        }
    }
}