window.addEventListener('load', eventos);
const $ = id => document.getElementById(id);

function eventos() {
    $('Mediano').addEventListener('click', consultarVehiculo);
    $('Pequeño').addEventListener('click', consultarVehiculo);
    $('Moto').addEventListener('click', consultarVehiculo);
    $('Familiar').addEventListener('click', consultarVehiculo);
    $('Deportivo').addEventListener('click', consultarVehiculo);
    $('Furgoneta').addEventListener('click', consultarVehiculo);

    function consultarVehiculo(event) {
        let vehiculo = event.target.id;
        console.log(vehiculo);
        window.location.href = 'PHP/vehiculos.php?vehiculo=' + vehiculo;

    }
}
