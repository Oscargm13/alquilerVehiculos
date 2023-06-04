<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/panelAdmin.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        #container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        select, input[type="text"], button {
            width: 100%;
            height: 30px;
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
        function existeParametro($parametro) {
            if(isset($_GET[$parametro])) {
                $valor = $_GET[$parametro];
            }else {
                $valor = "error";
            }
            return $valor;
        }
    ?>
    <div id="container">
        <h1>Tramitar alta</h1>
            <?php
            include '../includes/conexion.php';
            $query = "SELECT DISTINCT Modelos.brand FROM Modelos WHERE 1";
            $consulta = mysqli_query($conexion, $query);
            if(!$consulta) {
                die("La consulta falló: ".mysqli_error($conexion));
            }
            ?>
            <form action="altaVehiculo.php" id="form_alta" method="post" enctype="multipart/form-data">
                <label for="existe" id="lblAlta">Seleccione marca</label>
                <select name="existe" id="existe" required>
                    <option value="0">--seleccione un marca--</option>
                </select>
                <label for="">Selecciona un modelo</label>
                <select name="modelo" id="modelo" required>
                <option value="0">--seleccione un modelo--</option>
                </select>
                <label for="tipo">Seleccione el tipo de vehiculo que desee</label>
                <select name="tipo" id="tipo" required>
                    <?php
                        include '../includes/conexion.php';
                        $query = "SELECT DISTINCT `nombre_tipo` FROM `Modelos` WHERE 1;";
                        $consulta = mysqli_query($conexion, $query);
                        if(!$consulta) {
                            die("La consulta falló: ".mysqli_error($conexion));
                        }
                        echo "<option>--seleccione un tipo--</option>";
                        while ($fila = mysqli_fetch_array($consulta)) {
                            echo "<option>" . $fila["nombre_tipo"] . "</option>";
                        }
                    ?>
                </select>
                <label for="parking">Parking</label>
                <select name="parking" id="parking" required>
                    <?php
                    $query = "SELECT DISTINCT `ciudad`, id_parking FROM `Parkings` WHERE 1;";
                    $consulta = mysqli_query($conexion, $query);
                    if(!$consulta) {
                        die("La consulta falló: ".mysqli_error($conexion));
                    }
                        echo "<option>--seleccione una ciudad--</option>";
                        while ($fila = mysqli_fetch_array($consulta)) {
                            echo "<option value='".$fila["id_parking"]."'>" . $fila["ciudad"] . "</option>";
                        }
                        mysqli_close($conexion);
                    ?>
                </select>
                <label for="matricula">Matricula del vehiculo</label>
                <input type="text" id="matricula" name="matricula" pattern="[0-9]{4}[A-Za-z]{3}" required>
                <label for="imagen" id="lblImagen">Imagen del vehiculo</label>
                <input type="file" name="imagen" id="imagen">
                <button type="submit">Alta</button>
            </form>
    </div>
</body>
</html>
