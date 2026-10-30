
function gestionarSesionNav() {

    let ruta = window.location.pathname.includes("/modulos/")
        ? "../php/estadoSesion.php"
        : "php/estadoSesion.php";

    fetch(ruta)
        .then(respuesta => respuesta.json())
        .then(data => {

            let invitados = document.getElementById("nav-guest");
            let usuarios = document.getElementById("nav-user");
            if (data.sesion) {

                invitados.style.display = "none";
                usuarios.style.display = "flex";

                document.getElementById("nav-perfil").style.display = "inline";

                document.getElementById("nombre-usuario").textContent =
                    "Hola, " + data.nombre;

            } else {

                invitados.style.display = "flex";
                usuarios.style.display = "none";

                document.getElementById("nav-perfil").style.display = "none";

            }
        })
        .catch(error => console.log("Error de sesión:", error));


    let cerrar = document.getElementById("cerrar-sesion");

    if (cerrar) {
        cerrar.href = window.location.pathname.includes("/modulos/")
            ? "../php/cerrarSesion.php"
            : "php/cerrarSesion.php";
    }

}

