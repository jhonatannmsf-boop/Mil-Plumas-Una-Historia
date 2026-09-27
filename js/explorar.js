document.querySelectorAll(".boton-like").forEach((boton) => {

    let likes = 0;
    let dioLike = false;

    const contador = boton.querySelector(".contador");

    boton.addEventListener("click", () => {
        if (!dioLike) {
            likes++;
            dioLike = true;
            boton.classList.add("activo");
        } else {
            likes--;
            dioLike = false;
            boton.classList.remove("activo");
        }

        contador.textContent = likes;
    });

});
