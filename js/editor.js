let intervaloCronometro = null;

function iniciarCronometro(segundos) {
    let tiempoRestante = parseInt(segundos, 10);
    if (isNaN(tiempoRestante) || tiempoRestante <= 0) {
        tiempoRestante = 1800;
    }

    let elCronometro = document.getElementById("cronometro-turno");
    let textarea = document.getElementById("texto_capitulo");

    function actualizarReloj() {
        if (!elCronometro) return;

        let min = Math.floor(tiempoRestante / 60);
        let seg = tiempoRestante % 60;
        elCronometro.textContent = `⏳ ${String(min).padStart(2, '0')}:${String(seg).padStart(2, '0')}`;

        if (tiempoRestante <= 60) {
            elCronometro.classList.add("tiempo-bajo");
        } else {
            elCronometro.classList.remove("tiempo-bajo");
        }

        if (tiempoRestante <= 0) {
            clearInterval(intervaloCronometro);
            if (textarea) {
                textarea.removeAttribute("required");
            }
            document.getElementById("form-editor").submit();
            return;
        }

        tiempoRestante--;
    }

    if (intervaloCronometro) clearInterval(intervaloCronometro);
    actualizarReloj();
    intervaloCronometro = setInterval(actualizarReloj, 1000);
}

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

    if (!idHistoria || idHistoria === "0") {
        window.location.replace("explorar.html");
        return;
    }

    document.getElementById("id_historia").value = idHistoria;

    let btnCancelar = document.getElementById("btn-cancelar-turno");
    if (btnCancelar) {
        btnCancelar.onclick = function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Salir y liberar turno?",
                text: "Cualquier texto no guardado se perderá y otro usuario podrá tomar el turno.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, salir",
                cancelButtonText: "Seguir escribiendo",
                confirmButtonColor: "#c0392b"
            }).then(res => {
                if (res.isConfirmed) {
                    window.location.href = "../php/liberarTurno.php?id=" + idHistoria;
                }
            });
        };
    }

    fetch("../php/tomarTurno.php?id=" + idHistoria)
        .then(respuesta => respuesta.json())
        .then(data => {

            if (data.error) {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Turno no disponible",
                    text: data.error,
                    confirmButtonColor: '#5b8c60'
                }).then(() => {
                    window.location.replace("detalle.html?id=" + idHistoria);
                });
                return;
            }

            document.getElementById("editor-titulo").textContent = "📖 " + data.titulo;
            document.getElementById("texto_capitulo").dataset.limite = data.limite_palabras;
            document.getElementById("contador-palabras").textContent = "0 / " + data.limite_palabras + " palabras";

            iniciarCronometro(data.segundos_restantes);

        })
        .catch(error => console.log("Error al tomar el turno:", error));

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

window.addEventListener("pageshow", function() {
    if (textareaCapitulo) {
        textareaCapitulo.value = "";
        let contador = document.getElementById("contador-palabras");
        let limite = textareaCapitulo.dataset.limite || 300;
        if (contador) {
            contador.textContent = "0 / " + limite + " palabras";
            contador.style.color = "";
        }
    }
});
