function validarLogin(event) {
    let usuario = document.getElementById("login-usuario").value.trim();
    let pass = document.getElementById("login-pass").value;

    if (usuario === "" || pass === "") {
        if (event) event.preventDefault();
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Campos Vacíos",
            text: "Por favor ingresa tu usuario y contraseña",
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }
    return true;
}

function procesarLogin(event) {
    if (event) event.preventDefault();
    if (!validarLogin(event)) return false;

    const usuario = document.getElementById("login-usuario").value.trim();
    localStorage.setItem("usuario_activo", usuario);

    Swal.fire({
        position: "center",
        icon: "success",
        title: "¡Bienvenido de vuelta!",
        text: `Hola, @${usuario}. Has iniciado sesión.`,
        showConfirmButton: false,
        timer: 1200
    }).then(() => {
        window.location.href = "perfil.html";
    });

    return false;
}

function procesarLogin(event) {
  event.preventDefault(); 

  const usuarioInput = document.getElementById('login-usuario');
  const usuario = usuarioInput ? usuarioInput.value.trim() : '';

  if (usuario !== '') {
    
    localStorage.setItem('sesionIniciada', 'true');
    localStorage.setItem('usuarioNombre', usuario);

    
    window.location.href = 'index.html';
  } else {
    alert('Por favor ingresa un usuario');
  }
}