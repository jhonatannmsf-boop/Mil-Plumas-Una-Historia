let historialVistas = ['landing'];

function mostrarVista(idVista) {
    const vistas = document.querySelectorAll('.vista-modulo');
    vistas.forEach(v => v.classList.add('vista-oculta'));
    
    const vistaDestino = document.getElementById('vista-' + idVista);
    if(vistaDestino) {
        vistaDestino.classList.remove('vista-oculta');
        historialVistas.push(idVista);
    }
}

function volverAtras() {
    if (historialVistas.length > 1) {
        historialVistas.pop();
        const vistaAnterior = historialVistas[historialVistas.length - 1];
        const vistas = document.querySelectorAll('.vista-modulo');
        vistas.forEach(v => v.classList.add('vista-oculta'));
        document.getElementById('vista-' + vistaAnterior).classList.remove('vista-oculta');
    }
}

function abrirDetalle(titulo, genero) {
    document.getElementById('detalle-titulo').innerText = titulo;
    document.getElementById('detalle-genero').innerText = genero;
    mostrarVista('detalle');
}

function actualizarContadorWords() {
    const texto = document.getElementById('texto-capitulo').value.trim();
    const palabras = texto ? texto.split(/\s+/).length : 0;
    document.getElementById('contador-palabras').innerText = palabras + ' / 500 palabras';
}

function procesarRegistro(e) {
    e.preventDefault();
    const formData = new FormData(document.getElementById('form-registro'));
    formData.append('accion', 'registro');

    fetch('procesar.php', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(data => {
        if(data.exito) {
            actualizarInterfazUsuario(data.usuario);
            mostrarVista('perfil');
        } else {
            alert(data.mensaje);
        }
    });
}

function procesarLogin(e) {
    e.preventDefault();
    const formData = new FormData(document.getElementById('form-login'));
    formData.append('accion', 'login');

    fetch('procesar.php', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(data => {
        if(data.exito) {
            actualizarInterfazUsuario(data.usuario);
            mostrarVista('perfil');
        } else {
            alert(data.mensaje);
        }
    });
}

function procesarCrearHistoria(e) {
    e.preventDefault();
    const formData = new FormData(document.getElementById('form-crear'));
    formData.append('accion', 'crear_historia');

    fetch('procesar.php', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(data => {
        if(data.exito) {
            mostrarVista('explorar');
        } else {
            alert(data.mensaje);
        }
    });
}

function publicarCapitulo() {
    const contenido = document.getElementById('texto-capitulo').value;
    const formData = new FormData();
    formData.append('accion', 'publicar_capitulo');
    formData.append('historia_id', 1);
    formData.append('contenido', contenido);

    fetch('procesar.php', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(data => {
        if(data.exito) {
            alert('Capítulo publicado correctamente');
            mostrarVista('explorar');
        } else {
            alert(data.mensaje);
        }
    });
}

function actualizarInterfazUsuario(nombreUsuario) {
    document.getElementById('auth-nav').innerHTML = `<a class="link-cursivo" onclick="mostrarVista('perfil')">@${nombreUsuario}</a>`;
    document.getElementById('perfil-nombre').innerText = nombreUsuario;
    document.getElementById('perfil-user').innerText = '@' + nombreUsuario;
}