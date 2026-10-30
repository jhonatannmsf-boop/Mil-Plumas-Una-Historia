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

