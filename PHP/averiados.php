<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        window.addEventListener('load', cargarFecha);
        function cargarFecha() {
            let fecha = new Date();

            let dia = fecha.getDate();
            let mes = fecha.getMonth() + 1;
            let anio = fecha.getFullYear();

            let fechaFormateada = anio + '/' + mes + '/' + dia;

            console.log(fechaFormateada);

            document.getElementById('fechaActual').value = fechaFormateada; 
        }
        
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="averiados.php" method="post">

        <input type="hidden" value="" name="fechaActual" id="fechaActual">
        <label for="fechaFin">Fecha prevista para la reincorporacion del vehiculo</label>
        <input type="date" name="fechaFin">
        <label for="parkingDev">Parking de devolucion del vehiculo</label>
        <input type="text" name="parkingDev">
        <label for="matricula">Matricula del Vehiculo</label>
        <input type="text" value="" name="matricula">
        <input type="submit" value="enviar" name="enviar">
        
    </form>

    <?php
        if(isset($_POST['enviar'])){
            include '../includes/conexion.php';
            include_once '../includes/user.php';
            include_once '../includes/userSession.php';

            $userSession = new UserSession();
            $user = new User();
            $usuario = $userSession->getCurrentUser();
            $ciudad = $_POST['parkingDev'];
            $matricula = $_POST['matricula'];
            $fechaRecogida = $_POST['fechaActual'];
            $fechaDevolucion = $_POST['fechaFin'];

            $query = "SELECT * FROM `distribucion` WHERE license_plate = '".$matricula."';";

            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $parkingRecogida = $fila['id_parking'];
            }

            $query = "SELECT `dni` FROM `Customers` WHERE email = '".$usuario."';";
            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $dni = $fila['dni'];
            }

            $query = "INSERT INTO `rentals`(`rental_start_date`, `rental_end_date`, `start_parking_id`, `end_parking_id`, `license_plate`, `dni`, estado)
            VALUES ('$fechaRecogida','$fechaDevolucion','$parkingRecogida','$ciudad','$matricula','$dni', 'averiado')";
            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }
        }
    ?>
</body>
</html>