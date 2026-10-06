fetch("header.html")
  .then(response => response.text())
  .then(data => {
    document.getElementById("header").innerHTML = data;
    
    
    gestionarSesionNav();
  });

fetch("footer.html")
  .then(response => response.text())
  .then(data => {
    document.getElementById("footer").innerHTML = data;
  });

function gestionarSesionNav() {
  const navGuest = document.getElementById('nav-guest');
  const navUser = document.getElementById('nav-user');
  const userGreeting = document.getElementById('user-greeting');
  const btnLogout = document.getElementById('btn-logout');

  const sesionActiva = localStorage.getItem('sesionIniciada');
  const usuarioNombre = localStorage.getItem('usuarioNombre');

  if (sesionActiva === 'true') {
    if (navGuest) navGuest.style.setProperty('display', 'none', 'important');
    if (navUser) navUser.style.setProperty('display', 'flex', 'important');
    if (userGreeting && usuarioNombre) {
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
      window.location.href = 'index.html';
    });
  }

}