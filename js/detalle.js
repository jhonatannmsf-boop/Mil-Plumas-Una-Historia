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

                lista.appendChild(item);

            });

        })
        .catch(error => console.log("Error al cargar la historia:", error));

}

cargarDetalle();
