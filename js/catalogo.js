window.addEventListener('load', eventos);

    function eventos() {
        var formulario = document.getElementById('formulario-filtros');
        formulario.classList.add('hide');

        var alquilarButtons = document.querySelectorAll('#contenedor button#alquilar');
        alquilarButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var usuarioRegistrado = false;

                if (!usuarioRegistrado) {
                    event.preventDefault();
                    alert('Debe estar registrado para alquilar un vehículo.');
                }
            });
        });
    }
