document.querySelectorAll(".boton-like").forEach((boton) => {
    let likes = 0;
    let dioLike = false;
    const contador = boton.querySelector(".contador");

    boton.addEventListener("click", (e) => {
        e.stopPropagation();
        if (!dioLike) {
            likes++;
            dioLike = true;
            boton.classList.add("activo");
        } else {
            likes--;
            dioLike = false;
            boton.classList.remove("activo");
        }

        if (contador) {
            contador.textContent = likes;
        }
    });
});
