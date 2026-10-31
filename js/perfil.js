function mostrarNombrePerfil() {

    fetch("../php/estadoSesion.php")
        .then(respuesta => respuesta.json())
        .then(data => {

            if (data.sesion) {
                document.getElementById("perfil-nombre").textContent = data.nombre;
            }

        })
        .catch(error => console.log("Error de sesión:", error));

}

function cargarGuardados() {

    fetch("../php/listaGuardados.php")
        .then(respuesta => respuesta.json())
        .then(guardados => {

            let lista = document.getElementById("lista-guardados");

            if (guardados.length == 0) {
                lista.innerHTML = `<p class="has-text-centered is-size-5">Aún no tienes historias guardadas.</p>`;
                return;
            }

            guardados.forEach(historia => {

                let caja = document.createElement("div");
                caja.className = "caja-verde-formulario";

                caja.innerHTML = `
                    <div class="is-flex is-justify-content-space-between is-align-items-center">
                        <h3 class="link-cursivo is-size-3"></h3>
                    </div>
                    <a href="detalle.html?id=${historia.id_historia}" class="button btn-principal mt-3">Ver Historia</a>
                `;

                caja.querySelector("h3").textContent = historia.titulo;

                lista.appendChild(caja);

            });

        })
        .catch(error => console.log("Error al cargar guardados:", error));

}

mostrarNombrePerfil();
cargarGuardados();
