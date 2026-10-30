<?php

function alerta($icono, $titulo, $url = '') {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <script>
        window.addEventListener('load', function() {

            if (typeof Swal === 'undefined') {
                alert('No se pudo cargar SweetAlert2');
                return;
            }

            Swal.fire({
                position: 'center',
                icon: '$icono',
                title: '$titulo',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                if ('$url' !== '') {
                    window.location.href = '$url';
                }
            });

        });
    </script>";
}

?>


