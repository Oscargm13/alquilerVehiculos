<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        #form {
            width: 500px;
            margin: 0 auto;
            text-align: center;
            border: 1px solid;
            padding: 40px;
            border-radius: 10px;
        }

        #date-range-picker {
            width: 400px;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            font-size: 16px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            box-sizing: border-box;
            outline: none;
        }

        #calendar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        select {
            width: 100%;
            height: 40px;
            padding: 8px;
            font-size: 16px;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        select {
            appearance: none;
            background-color: #f5f5f5;
        }

        button {
            display: block;
            width: 100%;
            height: 40px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    </head>
    
    <body>
            <?php
              if(isset($_POST['alquilar'])) {
                $matricula = $_POST['alquilar'];
              }
              include "../includes/conexion.php";

              $query = "SELECT `rental_start_date`, `rental_end_date` FROM `rentals` WHERE license_plate = '$matricula'";
              $consulta = mysqli_query($conexion, $query);

              $arrayEntrada = array();
              $arraySalida = array();
              $i = 0;
              while ($fila = mysqli_fetch_array($consulta)) {

                $arrayEntrada[$i] = $fila['rental_start_date'];
                $arraySalida[$i++] = $fila['rental_end_date'];

              }
            ?>
            <script>
                let arrayEntrada = <?php echo json_encode($arrayEntrada); ?>;
                let arraySalida = <?php echo json_encode($arraySalida); ?>;
                let precio = <?php echo $_POST['precio'];?>
            </script>
            <div id="form">
              <h1>tramite de alquiler</h1>
                <label for="matricula">Matricula:</label>
                <input type="text" name="matricula" id="matricula" required readonly value="<?php echo $matricula ?>">
                <div id="calendar">
                    <input type="text" id="date-range-picker" placeholder="Selecciona un rango de fechas" required>
                </div>
                <span id="errFecha"></span>
                <br>
                <label for="parking">Indica el parking en el que va a realizar la devolucion</label>
                <select name="ciudad" id="ciudad" required>
                    <option value="1">Madrid</option>
                    <option value="2">Barcelona</option>
                    <option value="3">Valencia</option>
                    <option value="4">Sevilla</option>
                    <option value="5">Asturias</option>
                    <option value="6">Granada</option>
                </select>
                <span id="errCiu"></span>
                <button name="enviarAlquiler" id="enviarAlquiler">Siguiente</button>
            </div>
            

        <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.4"></script>
        <script src="https://unpkg.com/flatpickr"></script>
        <script src="../js/calendario.js"></script>
    </body>
</html>