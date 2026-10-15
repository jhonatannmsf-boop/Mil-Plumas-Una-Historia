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

function gestionarSesionNav() {
  const navGuest = document.getElementById('nav-guest');
  const navUser = document.getElementById('nav-user');
  const userGreeting = document.getElementById('user-greeting');
  const btnLogout = document.getElementById('btn-logout');

  const sesionActiva = localStorage.getItem('sesionIniciada');
  const usuarioNombre = localStorage.getItem('usuarioNombre') || localStorage.getItem('usuario_activo');

  if (sesionActiva === 'true' && usuarioNombre) {
    if (navGuest) navGuest.style.setProperty('display', 'none', 'important');
    if (navUser) navUser.style.setProperty('display', 'flex', 'important');
    if (userGreeting) {
      userGreeting.textContent = `Hola, ${usuarioNombre}`;
    }
  } else {
    if (navGuest) navGuest.style.setProperty('display', 'flex', 'important');
    if (navUser) navUser.style.setProperty('display', 'none', 'important');
  }

  if (btnLogout) {
    btnLogout.addEventListener('click', (e) => {
      e.preventDefault();
      localStorage.removeItem('sesionIniciada');
      localStorage.removeItem('usuarioNombre');
      localStorage.removeItem('usuario_activo');
      window.location.href = 'index.html';
    });
  }
}