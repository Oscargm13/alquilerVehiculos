<?php
    include_once 'includes/user.php';
    include_once 'includes/userSession.php';

    $userSession = new UserSession();
    $user = new User();

    if(isset($_SESSION['user'])){
        //echo "Hay session";
        $user->setUser($userSession->getCurrentUser());
        if ($user->isAdmin($userSession->getCurrentUser())) {
            // Redirigir al administrador a "home.php" con botón adicional
            $admin = "";
            $registrado = "";
            include_once 'php/home.php';

        } else {
            // Redirigir a otros usuarios a "home.php" sin el botón adicional
            $registrado = "";
            include_once 'php/home.php';
        }
    }else if(isset($_POST['mail']) && isset($_POST['password'])){
        //echo "Validacion de login";

        $userForm = $_POST['mail'];
        $passForm = md5($_POST['password']);

        if($user->userExists($userForm, $passForm)){
            //echo "usuario validado";
            $userSession->setCurrentUser($userForm);
            $user->setUser($userForm);
            $registrado = "";

            if ($user->isAdmin($userForm)) {
                // Redirigir al administrador a "home.php" con botón adicional
                $admin = "";
                include_once 'php/home.php';

            } else {
                // Redirigir a otros usuarios a "home.php" sin el botón adicional
                $noAdmin = "";
                include_once 'php/home.php';
            }
        }else{
            //echo "usuario incorrecto";
            $errorLogin = "usuario incorrecto";
            include_once 'html/singin.php';
        }
    }else if(isset($_GET['mail']) && isset($_GET['password'])) {
        $userForm = $_GET['mail'];
        $passForm = md5($_GET['password']);

        if($user->userExists($userForm, $passForm)){
            $noAdmin = $userForm.$passForm;
            $registrado = "";
            include_once 'php/home.php';
        }
    }else {
        //echo "login";
        $noRegistrado = "";
        include_once 'php/home.php';
    }
?>
<?php
// Establecer conexión con la base de datos
$conexion = mysqli_connect('localhost','oscar','contraseña','AlquilerVehiculos');

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Obtener las matrículas únicas de los vehículos
$query = "SELECT DISTINCT license_plate FROM Vehicles";
$resultado = mysqli_query($conexion, $query);

while($fila = mysqli_fetch_array($resultado)) {
    $matricula = $fila['license_plate'];
    $actualizarAlquilado = false; // Bandera para indicar si se debe actualizar el estado

    // Obtener los alquileres para la matrícula actual
    $queryAlquileres = "SELECT * FROM rentals WHERE license_plate = ?";
    $stmtAlquileres = mysqli_prepare($conexion, $queryAlquileres);
    mysqli_stmt_bind_param($stmtAlquileres, "s", $matricula);
    mysqli_stmt_execute($stmtAlquileres);
    $resultadoAlquileres = mysqli_stmt_get_result($stmtAlquileres);

    while($filaAlquiler = mysqli_fetch_array($resultadoAlquileres)) {
        if(isset($filaAlquiler['alquilado'])){
           $estado = $filaAlquiler['alquilado']; 
        }
        $fechaVencimiento = $filaAlquiler['rental_end_date'];
        $fechaInicio = $filaAlquiler['rental_start_date'];

        // Verificar si está en un alquiler y cumple la condición
        if ($fechaActual <= $fechaVencimiento && $fechaActual >= $fechaInicio) {
            $actualizarAlquilado = true;
            break; // Salir del bucle si se encuentra una coincidencia
        }
    }

    // Actualizar el estado solo si se encontró una coincidencia
    if ($actualizarAlquilado) {
        $queryUpdate = "UPDATE Vehicles SET alquilado = 1 WHERE license_plate = ?";
    } else {
        $queryUpdate = "UPDATE Vehicles SET alquilado = 0 WHERE license_plate = ?";
    }

    // Utilizar una consulta preparada para la actualización
    $stmtUpdate = mysqli_prepare($conexion, $queryUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "s", $matricula);
    mysqli_stmt_execute($stmtUpdate);

    // Cerrar la consulta preparada
    mysqli_stmt_close($stmtAlquileres);
    mysqli_stmt_close($stmtUpdate);
}

$query = "SELECT * FROM rentals WHERE rental_end_date < CURDATE()";
$consulta = mysqli_query($conexion, $query);

if (!$consulta) {
    die("La consulta falló: " . mysqli_error($conexion));
}

// Obtener todas las rentas caducadas
$rentasCaducadas = mysqli_fetch_all($consulta, MYSQLI_ASSOC);
mysqli_free_result($consulta); // Liberar los resultados de la consulta

// Mover las rentas caducadas a la tabla Historial
if (!empty($rentasCaducadas)) {
    $valoresInsertar = [];
    $idsRentasEliminar = [];

    foreach ($rentasCaducadas as $renta) {
        $fechaInicio = $renta['rental_start_date'];
        $fechaFin = $renta['rental_end_date'];
        $parkingRecogida = $renta['start_parking_id'];
        $parkingDevolucion = $renta['end_parking_id'];
        $matricula = $renta['license_plate'];
        $dni = $renta['dni'];
        $idAlquiler = $renta['id_rental'];
        $motivo = $renta['estado'];

        $valoresInsertar[] = "('$fechaInicio','$fechaFin','$parkingRecogida','$parkingDevolucion','$matricula','$dni','$idAlquiler','$motivo')";
        $idsRentasEliminar[] = $idAlquiler;
    }

    // Insertar las rentas caducadas en la tabla Historial
    $valoresInsertarStr = implode(", ", $valoresInsertar);
    $queryInsertar = "INSERT INTO `Historial`(`rental_start_date`, `rental_end_date`, `start_parking_id`, `end_parking_id`, `license_plate`, `dni`, `id_rental`, `motivo`) VALUES $valoresInsertarStr";
    $consultaInsertar = mysqli_query($conexion, $queryInsertar);

    if (!$consultaInsertar) {
        die("La consulta de inserción en Historial falló: " . mysqli_error($conexion));
    }

    // Eliminar las rentas caducadas de la tabla rentals
    $idsRentasEliminarStr = implode(", ", $idsRentasEliminar);
    $queryEliminar = "DELETE FROM `rentals` WHERE id_rental IN ($idsRentasEliminarStr)";
    $consultaEliminar = mysqli_query($conexion, $queryEliminar);

    if (!$consultaEliminar) {
        die("La consulta de eliminación de rentals falló: " . mysqli_error($conexion));
    }

    $parkingDevolucion = mysqli_real_escape_string($conexion, $parkingDevolucion); // Escapar caracteres especiales en el valor del parking de devolución

$queryActualizarDistribucion = "UPDATE distribucion SET id_parking = '$parkingDevolucion' WHERE license_plate = '$matricula'";
$consultaActualizarDistribucion = mysqli_query($conexion, $queryActualizarDistribucion);

if (!$consultaActualizarDistribucion) {
    die("La consulta de actualización en distribucion falló: " . mysqli_error($conexion));
}
}




// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>