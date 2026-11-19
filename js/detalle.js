function cargarDetalle() {

    let idHistoria = new URLSearchParams(window.location.search).get("id");

    document.getElementById("tomar-turno").href = "editor.html?id=" + idHistoria;

    fetch("../php/detalle.php?id=" + idHistoria)
        .then(respuesta => respuesta.json())
        .then(historia => {

            if (historia.error) {
                document.getElementById("detalle-titulo").textContent = historia.error;
                return;
            }

            document.getElementById("detalle-titulo").textContent = historia.titulo;
            document.getElementById("detalle-genero").textContent = historia.genero;
            document.getElementById("detalle-primer-capitulo").textContent = historia.primer_capitulo;
            document.getElementById("detalle-reglas").textContent =
                "Reglas: Máx. " + historia.limite_palabras + " palabras por turno";

            let btnTurno = document.getElementById("tomar-turno");
            if (btnTurno && historia.turno_actual) {
                if (historia.turno_actual.activo && !historia.turno_actual.es_mi_turno) {
                    let minRestantes = Math.ceil(historia.turno_actual.segundos_restantes / 60);
                    btnTurno.textContent = `⏳ En turno por ${historia.turno_actual.nombre_usuario} (~${minRestantes} min)`;
                    btnTurno.removeAttribute("href");
                    btnTurno.style.opacity = "0.6";
                    btnTurno.style.cursor = "not-allowed";
                    btnTurno.onclick = function(e) {
                        e.preventDefault();
                        Swal.fire({
                            icon: "info",
                            title: "Turno Ocupado",
                            text: `Esta historia la está editando ${historia.turno_actual.nombre_usuario}. Por favor espera a que termine o se agote su tiempo (~${minRestantes} min).`,
                            confirmButtonColor: "#5b8c60"
                        });
                    };
                } else if (historia.turno_actual.activo && historia.turno_actual.es_mi_turno) {
                    btnTurno.textContent = "Continuar mi Turno";
                    btnTurno.href = "editor.html?id=" + idHistoria;
                } else {
                    btnTurno.textContent = "Tomar Turno";
                    btnTurno.href = "editor.html?id=" + idHistoria;
                }
            }

            let lista = document.getElementById("lista-turnos");

            if (historia.turnos.length == 0) {
                lista.innerHTML = `<p class="has-text-centered is-size-5">Aún no hay turnos. ¡Sé el primero en continuar la historia!</p>`;
                return;
            }

            historia.turnos.forEach(turno => {

                let item = document.createElement("div");
                item.className = "turno-item";

                item.innerHTML = `
                    <div class="punto-conector"></div>
                    <div class="targeta-turno">
                        <div class="is-flex is-justify-content-space-between">
                            <span class="link-cursivo is-size-5"></span>
                            <span class="is-size-7"></span>
                        </div>
                        <p class="mt-2 is-size-6" style="line-height: 1.6; text-align: justify;"></p>
                    </div>
                `;

                item.querySelector(".is-size-5").textContent = "Turno #" + turno.numero_turno;
                item.querySelector(".is-size-7").textContent = turno.nombre_usuario || "Anónimo";
                item.querySelector("p").textContent = turno.contenido;

                if (historia.es_creador) {
                    let btnEliminar = document.createElement("button");
                    btnEliminar.type = "button";
                    btnEliminar.className = "btn-eliminar mt-3";
                    btnEliminar.textContent = "Eliminar capítulo";
                    btnEliminar.addEventListener("click", function() {
                        eliminarCapitulo(turno.id_capitulo);
                    });
                    item.querySelector(".targeta-turno").appendChild(btnEliminar);
                }

                lista.appendChild(item);

            });

        })
        .catch(error => console.log("Error al cargar la historia:", error));

}

function eliminarCapitulo(idCapitulo) {

    Swal.fire({
        title: "¿Eliminar este capítulo?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#c0392b"
    }).then(resultado => {

        if (resultado.isConfirmed) {

            let datos = new FormData();
            datos.append("id_capitulo", idCapitulo);

            fetch("../php/eliminarCapitulo.php", {
                method: "POST",
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(data => {

                if (data.error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.error
                    });
                    return;
                }

                window.location.reload();

            })
            .catch(error => console.log("Error al eliminar capítulo:", error));

        }

    });

}

cargarDetalle();
