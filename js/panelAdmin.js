window.addEventListener('load',eventos);
const $ = id => document.getElementById(id);

function eventos() {
    let marcas = $('existe')
    let modelos = $('modelo')

    modelos.addEventListener('change', function(){
        console.log(modelos.value.toLowerCase());
        let ruta = '../imagenes/imagenes_vehiculos/'+modelos.value.toLowerCase()+'.png';
        fetch(ruta)
        .then(response => {
        if (response.status === 404) {
            $('imagen').style.display = '';
            $('lblImagen').style.display = '';
        } else {
            $('imagen').style.display = 'none';
            $('lblImagen').style.display = 'none';
        }
        })
        .catch(error => {
        console.log('Error al verificar la imagen:', error);
        });
    })

    fetch('../JSON/marcas.json')
    .then(res => res.json())
    .then(datos => {
        datos.marcas.forEach(dato => {
            let option = document.createElement('option')
            option.setAttribute('value',dato.nombre)
            option.setAttribute('id',dato.nombre)
            option.appendChild(document.createTextNode(dato.nombre))
            marcas.appendChild(option)
        });
    })
    
    marcas.addEventListener('change',(evento)=>{
        while (modelos.firstChild) {
            modelos.removeChild(modelos.firstChild);
          }

        if(marcas.value != 0){
            fetch('../JSON/marcas.json')
            .then(response => response.json())
            .then(data => {
                const marcas2 = data.marcas;
                const audi = marcas2.find(marca => marca.nombre === marcas.value);
                const modelosAudi = audi.modelos;

                // Hacer algo con los modelos de Audi
                modelosAudi.forEach(dato => {
                let option = document.createElement('option')
                option.setAttribute('value',dato)
                option.setAttribute('id',dato)
                option.appendChild(document.createTextNode(dato))
                modelos.appendChild(option)
                })
            })
            .catch(error => {
                console.error('Error al cargar el archivo JSON:', error);
            });

        }
    })
}