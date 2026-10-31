function cargarHistorias() {

    fetch("../php/historias.php")
        .then(respuesta => respuesta.json())
        .then(historias => {

            let lista = document.getElementById("lista-historias");

            historias.forEach(historia => {

                let columna = document.createElement("div");
                columna.className = "column is-4";

                columna.innerHTML = `
                    <div class="tarjeta-libro">
                        <div class="portada-simulada" onclick="window.location.href='detalle.html?id=${historia.id_historia}'"></div>
                        <div>
                            <a href="detalle.html?id=${historia.id_historia}" class="link-cursivo is-size-4"></a>
                        </div>
                        <div class="is-size-5"></div>
                        <button type="button" class="boton-like" data-libro-id="${historia.id_historia}">
                            ❤️ Me gusta <span class="contador">0</span>
                        </button>
                    </div>
                `;

                columna.querySelector("a").textContent = historia.titulo;
                columna.querySelector(".is-size-5").textContent = historia.genero;

                if (historia.portada) {
                    columna.querySelector(".portada-simulada").style.backgroundImage =
                        "url(" + JSON.stringify(historia.portada) + ")";
                }

                lista.appendChild(columna);

            });

            activarLikes();

        })
        .catch(error => console.log("Error al cargar historias:", error));

}


function activarLikes() {

let botones = document.querySelectorAll(".boton-like");


botones.forEach(boton => {

    let idHistoria = boton.dataset.libroId;

    let datos = new FormData();
    datos.append("id_historia", idHistoria);
    datos.append("accion", "consultar");

    fetch("../php/guardados.php", {
        method: "POST",
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(data => {

        if (data.error) {
            console.log(data.error);
            return;
        }

        boton.querySelector(".contador").textContent = data.total;

        if (data.me_gusta) {
            boton.classList.add("activo");
        }

    })
    .catch(error => console.log("Error:", error));

});


botones.forEach(boton => {

    boton.addEventListener("click", function() {

        let datos = new FormData();

        datos.append("id_historia", this.dataset.libroId);
        datos.append("accion", "cambiar");

        fetch("../php/guardados.php", {
            method: "POST",
            body: datos
        })
        .then(respuesta => respuesta.json())
        .then(data => {

            if (data.error) {
                alert(data.error);
                return;
            }

            this.querySelector(".contador").textContent = data.total;

            if (data.me_gusta) {
                this.classList.add("activo");
            } else {
                this.classList.remove("activo");
            }

        })
        .catch(error => console.log("Error:", error));

    });

});

}

cargarHistorias();

let buscador = document.getElementById("buscador-libros");

buscador.addEventListener("input", function() {

    let texto = this.value.toLowerCase().trim();

    let libros = document.querySelectorAll(".tarjeta-libro");

    libros.forEach(libro => {

        let titulo = libro.querySelector("a").textContent.toLowerCase();

        let columna = libro.closest(".column");

        if (titulo.includes(texto)) {
            columna.style.display = "";
        } else {
            columna.style.display = "none";
        }

    });

});

