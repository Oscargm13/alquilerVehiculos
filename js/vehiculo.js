window.addEventListener('load', eventos);
const $ = id => document.getElementById(id);

function eventos() {
    
}
function mostrarInformacion(info) {
        window.location.href = "informacionVehiculo.php?matricula="+info;
    }