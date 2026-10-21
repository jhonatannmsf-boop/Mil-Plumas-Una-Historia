const enModulos = window.location.pathname.replace(/\\/g, '/').includes('/modulos/');
const rutaBase = enModulos ? "" : "modulos/";

fetch(rutaBase + "header.html")
  .then(response => response.text())
  .then(data => {
    const headerEl = document.getElementById("header");
    if (headerEl) {
      if (!enModulos) {
        data = data
          .replace(/href="\.\.\/css\//g, 'href="css/')
          .replace(/href="\.\.\/index\.html"/g, 'href="index.html"')
          .replace(/href="([^"#:]+\.html)"/g, (match, p1) => {
            return (p1 === "index.html") ? 'href="index.html"' : `href="modulos/${p1}"`;
          });
      }
      headerEl.innerHTML = data;
      if (typeof gestionarSesionNav === "function") {
        gestionarSesionNav();
      }
    }
  })
  .catch(err => console.warn("No se pudo cargar header.html:", err));

fetch(rutaBase + "footer.html")
  .then(response => response.text())
  .then(data => {
    const footerEl = document.getElementById("footer");
    if (footerEl) {
      if (!enModulos) {
        data = data.replace(/href="\.\.\/css\//g, 'href="css/');
      }
      footerEl.innerHTML = data;
    }
  })
  .catch(err => console.warn("No se pudo cargar footer.html:", err));
