<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <style>
        /* Estilos generales */
        body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

#container {
  width: 40%;
  margin: 0 auto;
  padding: 20px;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

label {
  font-weight: bold;
  margin-bottom: 10px;
}

select {
  margin-bottom: 10px;
  padding: 5px;
  width: 100%;
}

.inicio {
  margin-bottom: 10px;
}

button {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}

/* Estilos específicos para el catálogo de vehículos */
#contenedor {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin-top: 20px;
  width: 60%;
  margin: auto;

}

.titulo {
  text-align: center;
  font-size: 34px;
  margin-bottom: 20px;
}

.caja {
  width: 300px;
  margin: 0 10px 20px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
}

.caja:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

img {
  width: 100%;
  height: auto;
  margin-bottom: 10px;
  border-radius: 5px;
}

.texto {
  font-size: 14px;
  color: #555;
}

button#alquilar {
  margin-top: 10px;
  padding: 5px 10px;
  background-color: #28a745;
  transition: background-color 0.3s ease;
}

button#alquilar:hover {
  background-color: #1f9232;
}
#formulario-filtros.hide {
  display: none;
}


    </style>
</head>
<body>
    <div id="container">
        <form method="post" id="formulario-filtros">
            <h1>Filtros</h1>
            <select name="ciudad" id="ciudad">
                <option value="%">Todas las ciudades</option>
                <option value="Madrid">Madrid</option>
                <option value="Barcelona">Barcelona</option>
                <option value="Valencia">Valencia</option>
                <option value="Sevilla">Sevilla</option>
                <option value="Asturias">Asturias</option>
                <option value="Granada">Granada</option>
            </select>
            <select name="categoria" id="categoria">
                <option value="%">Todas las categorias</option>
                <option value="Pequeño">Pequeño</option>
                <option value="Mediano">Mediano</option>
                <option value="SUV">SUV</option>
                <option value="Furgoneta">Furgoneta</option>
                <option value="Deportivo">Deportivo</option>
                <option value="Familiar">Familiar</option>
            </select>

            <div class="inicio"><label for="guardar"><input type="checkbox" id="guardar">Mostrar solo los vehiculos disponibles</label></div>

            <button type="submit" name="enviar" id="aplicar" onclick="aplicarFiltros(event)" >Aplicar filtros</button>
        </form>
    </div>
    
   <?php
    include_once '../includes/user.php';
    include_once '../includes/userSession.php';

    $userSession = new UserSession();
    $user = new User();

    if(isset($_POST["enviar"])||isset($_GET['vehiculo'])){
        //Guardamos valor del select
        
        if(isset($_GET['vehiculo'])) {
          $ciudad = '%';
          $categoria = $_GET['vehiculo'];
        }else if(isset($_POST["enviar"])) {
          $ciudad = $_POST['ciudad'];
          $categoria = $_POST['categoria'];
        }

        //conexión
        include '../includes/conexion.php';
        //ejecutamos select
            $query = "SELECT Vehicles.license_plate, Vehicles.brand, Vehicles.model, Parkings.name_parking, Modelos.imagen, Modelos.nombre_tipo,Tipos.precio,
            CASE Vehicles.alquilado WHEN 1 THEN 'Ocupado' WHEN 0 THEN 'Disponible' END AS estado 
            FROM Vehicles, Distribucion, Parkings, Modelos, Tipos 
            WHERE Vehicles.license_plate = Distribucion.license_plate AND Parkings.id_parking = Distribucion.id_parking
            AND Parkings.ciudad LIKE '$ciudad' AND Modelos.nombre_tipo LIKE '$categoria' AND Vehicles.id_modelo = Modelos.id_modelo AND Modelos.nombre_tipo = Tipos.nombre_tipo;";

        //ejecutamos consulta
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        echo "<h1 class='titulo'>Catalogo de vehículos</h1>";
        echo "<div id='contenedor'>";
        

        while ($fila = mysqli_fetch_array($consulta)) {
          $precio = $fila['precio'];
            echo "<div class='caja'>";
            echo "<form method='post' action='tramiteAlquiler.php'>";
            echo "<img src='../imagenes/imagenes_vehiculos/".$fila["imagen"]."'> <p>Modelo: " . $fila["brand"] ." ". $fila["model"] . "</p>";
            echo "<div class='texto'>";
            echo "<p>Parking: " . $fila["name_parking"] . "</p><p>Tipo de vehiculo: " . $fila["nombre_tipo"] . "</p>";
            echo "<p>Disponibilidad: " . $fila["estado"] . "</p>";
            echo "<input type='hidden' name='precio' value='$precio'></input>";
            echo "<p>Precio por dia: " . $fila["precio"] . "€</p>";
            echo "<button name='alquilar' value='".$fila["license_plate"]."' id='alquilar'>Alquilar vehiculo</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            //echo "<tr><td>" . $fila["brand"] ." ". $fila["model"] . "</td><td>" . $fila["name_parking"] . "</td><td>" . $fila["nombre_tipo"] ."</td><td>". $fila["estado"] ."</td><tr>";
        }

        echo "</div>";
        echo "<script>
        window.addEventListener('load', eventos);
        function eventos() {
          var formulario = document.getElementById('formulario-filtros');
        formulario.classList.add('hide');";
          if(!isset($_SESSION['user'])){
            echo "
            var alquilarButtons = document.querySelectorAll('#contenedor button#alquilar');
            alquilarButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    var usuarioRegistrado = false; // Set this value based on your registration logic
    
                    if (!usuarioRegistrado) {
                        event.preventDefault();
                        alert('Debe estar registrado para alquilar un vehículo.');
                    }
                });
            });
            ";
          }
        echo "
        

        
}

    </script>";


        mysqli_close($conexion);
    }
    
   
?>
</body>
</html>