window.addEventListener('load', eventos);
let diferencia;
function eventos() {
  console.log(arrayEntrada);
  console.log(arraySalida);
  let fechaEntrada = dayjs(arrayEntrada[0]);
  let fechaSalida = dayjs(arraySalida[0]);
  diferencia = fechaSalida.diff(fechaEntrada, 'day');
  console.log(diferencia);
}

document.addEventListener('DOMContentLoaded', function() {
  var startDate;
  var endDate;
  var daysDiff;
  flatpickr('#date-range-picker', {
    mode: 'range',
    onChange: function(selectedDates, dateStr, instance) {
      if (selectedDates.length === 2) {
        startDate = dayjs(selectedDates[0]);
        endDate = dayjs(selectedDates[1]);

        daysDiff = endDate.diff(startDate, 'day');

        console.log('Fecha de inicio:', startDate.format('YYYY-MM-DD'));
        console.log('Fecha final:', endDate.format('YYYY-MM-DD'));
        console.log('Días de diferencia:', daysDiff);
      }
    },
    disable: [
      function(date) {

        var fechasBloqueadas = [];

        for (var i = 0; i < arrayEntrada.length; i++) {
          fechasBloqueadas.push(arrayEntrada[i]);

          var fechaEntrada = dayjs(arrayEntrada[i]);
          var fechaSalida = dayjs(arraySalida[i]);

          while (fechaEntrada.isBefore(fechaSalida)) {
            fechaEntrada = fechaEntrada.add(1, 'day');
            fechasBloqueadas.push(fechaEntrada.format('YYYY-MM-DD'));
          }

          fechasBloqueadas.push(arraySalida[i]);
        }

        var fecha = dayjs(date).format('YYYY-MM-DD');

     
        if (fechasBloqueadas.includes(fecha)) {
          return true;
        }
        return false;
      }
    ]
  });
  
  var guardarButton = document.getElementById('enviarAlquiler');
  // Dentro del evento click del botón "enviarAlquiler"
guardarButton.addEventListener('click', function() {
  let fechaInicio = startDate.format('YYYY-MM-DD');
  let fechaFin = endDate.format('YYYY-MM-DD');
  let matricula = document.getElementById('matricula').value;
  let ciudad = document.getElementById('ciudad').value;
  precio = precio * (daysDiff+1);
  console.log(daysDiff);
  console.log(precio);
  
  if (fechaInicio && fechaFin) {

    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'pasarela.php';

    var fechaInicioInput = document.createElement('input');
    fechaInicioInput.type = 'hidden';
    fechaInicioInput.name = 'fechaInicio';
    fechaInicioInput.value = fechaInicio;

    var fechaFinInput = document.createElement('input');
    fechaFinInput.type = 'hidden';
    fechaFinInput.name = 'fechaFin';
    fechaFinInput.value = fechaFin;

    var matriculaInput = document.createElement('input');
    matriculaInput.type = 'hidden';
    matriculaInput.name = 'matricula';
    matriculaInput.value = matricula;

    var ciudadInput = document.createElement('input');
    ciudadInput.type = 'hidden';
    ciudadInput.name = 'ciudad';
    ciudadInput.value = ciudad;

    var precioInput = document.createElement('input');
    precioInput.type = 'hidden';
    precioInput.name = 'precio';
    precioInput.value = precio;


    form.appendChild(fechaInicioInput);
    form.appendChild(fechaFinInput);
    form.appendChild(matriculaInput);
    form.appendChild(ciudadInput);
    form.appendChild(precioInput);


    document.body.appendChild(form);
    form.submit();
  }
});

});

