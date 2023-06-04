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
        $query = "SELECT license_plate, Vehicles.brand, Vehicles.model, nombre_tipo, alquilado, Modelos.id_modelo  FROM `Vehicles`, Modelos
        WHERE Vehicles.id_modelo = Modelos.id_modelo AND license_plate = '".$_POST["matricula"]."';";
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        echo '<form method="post" action="informacionVehiculo.php">';
        while ($fila = mysqli_fetch_array($consulta)) {
        echo "<label>Matricula:</label><input type='text' readonly name='matricula' value = '".$fila["license_plate"]."'>
        <label>Marca:</label><input type='text' name='marca' value = '".$fila["brand"]."'>
        <label>Modelo:</label><input type='text' name='modelo' value = '".$fila["model"]."'>
        <label>Nombre_tipo:</label><input type='text' name='nombre_tipo' value = '".$fila["nombre_tipo"]."'>
        <label>Alquilado:</label><input type='text' name='alquilado' value = '".$fila["alquilado"]."'>
        <label>Id_modelo:</label><input type='text' name='id_modelo' value = '".$fila["id_modelo"]."'>";
        }
        echo "<button type='submit' name='enviar'>Modificar información de vehiculo</button>
        </form>";
        mysqli_close($conexion);
      }else if(isset($_GET['matricula'])){
        include '../includes/conexion.php';
        $query = "SELECT Vehicles.model, Vehicles.brand, license_plate, Modelos.nombre_tipo, alquilado, Modelos.id_modelo
        FROM `Vehicles`, Modelos WHERE Vehicles.id_modelo=Modelos.id_modelo AND license_plate = '".$_GET["matricula"]."';";
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        echo '<form method="post" action="informacionVehiculo.php">';
        while ($fila = mysqli_fetch_array($consulta)) {
        echo "<label>Matricula:</label><input type='text' readonly name='matricula' value = '".$fila["license_plate"]."'>
        <label>Marca:</label><input type='text' name='marca' value = '".$fila["brand"]."'>
        <label>Modelo:</label><input type='text' name='modelo' value = '".$fila["model"]."'>
        <label>Nombre_tipo:</label><input type='text' name='nombre_tipo' value = '".$fila["nombre_tipo"]."'>
        <label>Alquilado:</label><input type='text' name='alquilado' value = '".$fila["alquilado"]."'>
        <input type='hidden' name='id_modelo' value = '".$fila["id_modelo"]."'>";
        }
        echo "<button type='submit' name='enviar'>Modificar información de vehiculo</button>
        </form>";
        mysqli_close($conexion);
      }
        ?>
    </div>
    <?php
        if(isset($_POST["enviar"])){

            if(isset($_POST["marca"])){
                $marca = $_POST["marca"];
            }
            if(isset($_POST["modelo"])){
                $modelo = $_POST["modelo"];
            }
            if(isset($_POST["nombre_tipo"])){
                $nombre_tipo = $_POST["nombre_tipo"];
            }
            if(isset($_POST["alquilado"])){
                $alquilado = $_POST["alquilado"];
            }
            if(isset($_POST["id_modelo"])){
                $id_modelo = $_POST["id_modelo"];
            }
            if(isset($_POST['matricula'])) {
                $matricula = $_POST['matricula'];
            }

            $conexion = mysqli_connect('localhost','oscar','contraseña','AlquilerVehiculos');
            if($conexion -> connect_error){
                die('Error en la conexion');
            };

            $query = "UPDATE `Vehicles` SET `model`='".$modelo."',`brand`='".$marca."',`alquilado`='".$alquilado."',`id_modelo`='".$id_modelo."' WHERE license_plate = '".$matricula."';";
            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }
            $query = "UPDATE `Modelos` SET nombre_tipo='$nombre_tipo' WHERE id_modelo = '$id_modelo'";
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
