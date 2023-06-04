<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        include_once '../includes/user.php';
        include_once '../includes/userSession.php';

        $userSession = new UserSession();
        $user = new User();
        $usuario = $userSession->getCurrentUser();

        if(isset($_GET['perfil'])){
            $query = "SELECT `rental_start_date`, `rental_end_date`, `start_parking_id`, `end_parking_id`, `license_plate`, rentals.dni, `id_rental`, name_customer, estado 
            FROM `rentals`, Customers
            WHERE Customers.dni = rentals.dni AND Customers.email = '$usuario';";
        }else {
            $query="SELECT `rental_start_date`, `rental_end_date`, `start_parking_id`, `end_parking_id`, `license_plate`, rentals.dni, `id_rental`, name_customer, estado 
            FROM `rentals`, Customers
            WHERE Customers.dni = rentals.dni;";
        }
        
        $consulta = mysqli_query($conexion, $query);
    ?>
    <table>
        <tr>
            <th>ID_alquiler</th>
            <th>Fecha de alquiler</th>
            <th>Fecha de devolucion</th>
            <th>Parking devolucion</th>
            <th>Usuario</th>
            <th>DNI del usuario</th>
            <th>matricula del vehiculo</th>
            <th>Estado del vehiculo</th>
        </tr>
        <?php
            while ($fila = mysqli_fetch_array($consulta)) {
                echo "<tr>";
                echo "<td>".$fila['id_rental']."</td><td>".$fila['rental_start_date']."</td>
                <td>".$fila['rental_end_date']."</td><td>".$fila['end_parking_id']."</td><td>".$fila['name_customer']."</td>
                <td>".$fila['dni']."</td><td>".$fila['license_plate']."</td><td>".$fila['estado']."</td>";
                echo "<tr>";
            }
        ?>
    </table>
</body>
</html>