<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/vehiculo.js"></script>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <?php

        include '../includes/conexion.php';
        $query="SELECT Vehicles.model, Vehicles.brand, Vehicles.license_plate, `nombre_tipo`,
        CASE Vehicles.alquilado WHEN 1 THEN 'Ocupado' WHEN 0 THEN 'Disponible' END AS estado, Vehicles.id_modelo,
        Parkings.name_parking, Parkings.id_parking
        FROM `Vehicles`, distribucion, Parkings, Modelos
        WHERE Vehicles.license_plate = distribucion.license_plate AND distribucion.id_parking = Parkings.id_parking AND Vehicles.id_modelo = Modelos.id_modelo;";
        $consulta = mysqli_query($conexion, $query);

    ?>
    <table>
        <tr>
            <th>Matricula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Tipo de vehiculo</th>
            <th>Estado actual</th>
            <th>Id_modelo</th>
            <th>Parking</th>
            <th>Id_parking</th>
        </tr>
        <?php
            while ($fila = mysqli_fetch_array($consulta)) {
                $matricula = $fila['license_plate'];
                echo "<tr onclick='mostrarInformacion(".json_encode($matricula).")'>";
                echo "<td>".$fila['license_plate']."</td><td>".$fila['brand']."</td>
                <td>".$fila['model']."</td><td>".$fila['nombre_tipo']."</td><td>".$fila['estado']."</td>
                <td>".$fila['id_modelo']."</td><td>".$fila['name_parking']."</td><td>".$fila['id_parking']."</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>