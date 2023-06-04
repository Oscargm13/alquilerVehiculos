<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #container {
            width: 60%;
            margin: 0 auto;
        }
        form {
            display: flex;
            flex-direction: column;
            text-align: center;
            font-weight: bolder;
        }
        form input {
            text-align: center;
            height: 30px;
            margin: 10px;
        }
        #resultado {
            width: 60%
            margin: 0 auto;
            text-align: center;
            color: green;
        }
    </style>
</head>
<body>
    <div id="container">
      <?php
      if(isset($_POST["info"])){
        include '../includes/conexion.php';
        $query = "SELECT * FROM `Parkings` WHERE id_parking = '".$_POST["id"]."';";
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        echo '<form method="post" action="informacionParking.php">';
        while ($fila = mysqli_fetch_array($consulta)) {
        echo "<label>Id del parking:</label><input type='text' readonly name='id' value = '".$fila["id_parking"]."'>
        <label>Nombre del parking:</label><input type='text' name='nombre' value = '".$fila["name_parking"]."'>
        <label>Ciudad en la que esta ubicado:</label><input type='text' name='ciudad' value = '".$fila["ciudad"]."'>
        <label>Ubicacion:</label><input type='text' name='ubicacion' value = '".$fila["location_parking"]."'>
        <label>Responsable del parking:</label><input type='text' name='responsable' value = '".$fila["responsable"]."'>
        <label>Telefono:</label><input type='text' name='tlf' value = '".$fila["telefono"]."'>";
        }
        echo "<button type='submit' name='enviar'>Modificar información de parking</button>
        </form>";
        mysqli_close($conexion);
      }
        ?>
    </div>
    <?php
        if(isset($_POST["enviar"])){

            if(isset($_POST["id"])){
                $id = $_POST["id"];
            }
            if(isset($_POST["nombre"])){
                $nombre = $_POST["nombre"];
            }
            if(isset($_POST["ciudad"])){
                $ciudad = $_POST["ciudad"];
            }
            if(isset($_POST["ubicacion"])){
                $ubicacion = $_POST["ubicacion"];
            }
            if(isset($_POST["responsable"])){
                $responsable = $_POST["responsable"];
            }
            if(isset($_POST['tlf'])) {
                $tlf = $_POST['tlf'];
            }

            $conexion = mysqli_connect('localhost','oscar','contraseña','AlquilerVehiculos');
            if($conexion -> connect_error){
                die('Error en la conexion');
            };

            $query = "UPDATE `Parkings` SET `name_parking`='".$nombre."',`ciudad`='".$ciudad."',`location_parking`='".$ubicacion.
            "',`responsable`='".$responsable."',`telefono`='".$tlf."' WHERE id_parking = '".$id."';";

            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }else {
                echo "
                <h1>Datos modificados</h1>
                <br>
                <a href='../index.php'>Volverl al inicio</a>
                ";
            }

            mysqli_close($conexion);
        }
    ?>
</body>
</html>