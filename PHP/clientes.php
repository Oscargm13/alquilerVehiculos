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
        $query="SELECT `name_customer`, `email`, phone_number, `domicilio`,
        `dni`, carnet
        FROM Customers WHERE 1";
        $consulta = mysqli_query($conexion, $query);

    ?>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Numero de telefono</th>
            <th>Domicilio</th>
            <th>DNI</th>
            <th>Carnet</th>
        </tr>
        <?php
            while ($fila = mysqli_fetch_array($consulta)) {
                echo "<tr>";
                echo "<td>".$fila['name_customer']."</td><td>".$fila['email']."</td>
                <td>".$fila['phone_number']."</td><td>".$fila['domicilio']."</td><td>".$fila['dni']."</td>
                <td><a href='../imagenes/dni/".$fila['carnet']."'>Ver documento</a></td>";
                echo "</tr>";
            }
        ?>
        
    </table>
</body>
</html>