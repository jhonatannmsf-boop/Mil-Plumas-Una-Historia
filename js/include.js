fetch("header.html")
  .then(response => response.text())
  .then(data => {
    const headerEl = document.getElementById("header");
    if (headerEl) {
      headerEl.innerHTML = data;
      gestionarSesionNav();
    }
  })
  .catch(err => console.warn("No se pudo cargar header.html:", err));

fetch("footer.html")
  .then(response => response.text())
  .then(data => {
    const footerEl = document.getElementById("footer");
    if (footerEl) {
      footerEl.innerHTML = data;
    }
  })
  .catch(err => console.warn("No se pudo cargar footer.html:", err));

