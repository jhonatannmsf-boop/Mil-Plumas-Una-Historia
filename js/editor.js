function validarEditor(event) {
    let textarea = document.getElementById("texto_capitulo");
    if (!textarea) return false;

    let contenido = textarea.value.trim();
    let palabras = contenido ? contenido.split(/\s+/).filter(Boolean).length : 0;
    let limite = textarea.dataset.limite ? parseInt(textarea.dataset.limite) : 300;

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

    return true;
}

document.getElementById("publicar_turno").onclick = validarEditor;

function cargarHistoriaEditor() {

    let idHistoria = new URLSearchParams(window.location.search).get("id");

    document.getElementById("id_historia").value = idHistoria;

    fetch("../php/detalle.php?id=" + idHistoria)
        .then(respuesta => respuesta.json())
        .then(historia => {

            if (historia.error) {
                document.getElementById("editor-titulo").textContent = historia.error;
                return;
            }

            document.getElementById("editor-titulo").textContent = "📖 " + historia.titulo;
            document.getElementById("texto_capitulo").dataset.limite = historia.limite_palabras;
            document.getElementById("contador-palabras").textContent = "0 / " + historia.limite_palabras + " palabras";

        })
        .catch(error => console.log("Error al cargar la historia:", error));

}

cargarHistoriaEditor();

const textareaCapitulo = document.getElementById("texto_capitulo");
if (textareaCapitulo) {
    textareaCapitulo.oninput = () => {
        let contenido = textareaCapitulo.value.trim();
        let palabras = contenido ? contenido.split(/\s+/).filter(Boolean).length : 0;
        let limite = textareaCapitulo.dataset.limite ? parseInt(textareaCapitulo.dataset.limite) : 300;
        let contador = document.getElementById("contador-palabras");
        if (contador) {
            contador.textContent = `${palabras} / ${limite} palabras`;
            contador.style.color = palabras > limite ? "red" : "";
        }
    };
}
