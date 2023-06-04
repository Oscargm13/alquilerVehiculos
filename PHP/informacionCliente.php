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
        $query = "SELECT * FROM `Customers` WHERE dni = '".$_POST["dni"]."';";
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        echo '<form method="post" action="informacionCliente.php">';
        while ($fila = mysqli_fetch_array($consulta)) {
        echo "<label>dni:</label><input type='text' readonly name='dni' value = '".$fila["dni"]."'>
        <label>Nombre y apellidos:</label><input type='text' name='nombre' value = '".$fila["name_customer"]."'>
        <label>Email:</label><input type='text' name='email' value = '".$fila["email"]."'>
        <label>Numero de telefono:</label><input type='text' name='numero' value = '".$fila["phone_number"]."'>
        <label>Ciudad de residencia:</label><input type='text' name='ciudad' value = '".$fila["domicilio"]."'>
        <label>Contraseña de usuario:</label><input type='text' name='pass' value = '".$fila["pass"]."'>";
        }
        echo "<button type='submit' name='enviar'>Modificar información de cliente</button>
        </form>";
        mysqli_close($conexion);
      }
        ?>
    </div>
    <?php
        if(isset($_POST["enviar"])){

            if(isset($_POST["nombre"])){
                $nombre = $_POST["nombre"];
            }
            if(isset($_POST["email"])){
                $email = $_POST["email"];
            }
            if(isset($_POST["numero"])){
                $numero = $_POST["numero"];
            }
            if(isset($_POST["ciudad"])){
                $ciudad = $_POST["ciudad"];
            }
            if(isset($_POST["pass"])){
                $pass = $_POST["pass"];
            }
            if(isset($_POST['dni'])) {
                $dni = $_POST['dni'];
            }

            $conexion = mysqli_connect('localhost','oscar','contraseña','AlquilerVehiculos');
            if($conexion -> connect_error){
                die('Error en la conexion');
            };

            $query = "UPDATE `Customers` SET `name_customer`='".$nombre."',`email`='".$email."',`phone_number`='".$numero.
            "',`domicilio`='".$ciudad."',`pass`='".$pass."' WHERE dni = '".$dni."';";

            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }else {
                    header("Location: ../html/panelAdmin.html");
                    exit();
                }

            mysqli_close($conexion);
        }
    ?>
</body>
</html>