<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
  include_once "../includes/user.php";
  include_once "../includes/userSession.php";
  
  if(isset($_POST['fechaIni'])){
    $userSession = new UserSession();
    $user = new User();
    $usuario = $userSession->getCurrentUser();
    $ciudad = $_POST['ciudad'];
    $matricula = $_POST['matricula'];
    $fechaRecogida = $_POST['fechaIni'];
    $fechaDevolucion = $_POST['fechaFin'];

        include '../includes/conexion.php';
        //Sacar parking de recogida del vehiculo
        $query = "SELECT * FROM `distribucion` WHERE license_plate = '".$matricula."';";

        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        while ($fila = mysqli_fetch_assoc($consulta)) {
            $parkingRecogida = $fila['id_parking'];
        }

        //Sacar dni del Cliente
        $query = "SELECT `dni`, name_customer FROM `Customers` WHERE email = '".$usuario."';";
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }

        while ($fila = mysqli_fetch_assoc($consulta)) {
            $dni = $fila['dni'];
            $nombre = $fila['name_customer'];
        }

        //Insertar datos en la tabla rentals
        $query="INSERT INTO `rentals`(`rental_start_date`, `rental_end_date`, `start_parking_id`, `end_parking_id`, `license_plate`, `dni`)
        VALUES ('$fechaRecogida','$fechaDevolucion','$parkingRecogida','$ciudad','$matricula','$dni')";
        $consulta = mysqli_query($conexion, $query);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }
        }
        if(isset($_GET['fechaIni'])){
            $userSession = new UserSession();
            $user = new User();
            $usuario = $userSession->getCurrentUser();
            $ciudad = $_GET['ciudad'];
            $matricula = $_GET['matricula'];
            $fechaRecogida = $_GET['fechaIni'];
            $fechaDevolucion = $_GET['fechaFin'];
            $idCompra = $_GET['idCompra'];
            $precio2 = $_GET['precio2'];
        
                include '../includes/conexion.php';
                //Sacar parking de recogida del vehiculo
                $query = "SELECT * FROM `distribucion` WHERE license_plate = '".$matricula."';";
        
                $consulta = mysqli_query($conexion, $query);
                if(!$consulta) {
                    die("La consulta falló: ".mysqli_error($conexion));
                }
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    $parkingRecogida = $fila['id_parking'];
                }
        
                //Sacar dni del Cliente
                $query = "SELECT `dni`, name_customer FROM `Customers` WHERE email = '".$usuario."';";
                $consulta = mysqli_query($conexion, $query);
                if(!$consulta) {
                    die("La consulta falló: ".mysqli_error($conexion));
                }
        
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    $dni = $fila['dni'];
                    $nombre = $fila['name_customer'];
                }
        
                //Insertar datos en la tabla rentals
                $query="INSERT INTO `rentals`(`rental_start_date`, `rental_end_date`, `start_parking_id`, `end_parking_id`, `license_plate`, `dni`, estado)
                VALUES ('$fechaRecogida','$fechaDevolucion','$parkingRecogida','$ciudad','$matricula','$dni', 'alquilado')";
                $consulta = mysqli_query($conexion, $query);
                if(!$consulta) {
                    die("La consulta falló: ".mysqli_error($conexion));
                }else
                {

                    

 
                    require '../phpMailer/Exception.php';
                    require '../phpMailer/PHPMailer.php';
                    require '../phpMailer/SMTP.php';
       
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.office365.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'alquilervehiculosprueba@outlook.es';
                        $mail->Password   = 'HOLAOSCAR13';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        //Recipients
                        $mail->setFrom('alquilervehiculosprueba@outlook.es', 'Equipo de Autorent');
                        $mail->addAddress($usuario, $nombre);


                        //Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Asunto';
                        $mail->Body    = '<h1>Gracias por su Alquiler, '.$nombre.'</h1><br><br><br>
                        <p>ID de compra: '.$idCompra.'</p><br><p>Coste total: '.$precio2.'€</p>';
                        $mail->AltBody = 'contenido';

                        $mail->send();
                        echo 'Message has been sent';
                        header("Location: ../index.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
                }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Compra finalizada</h1>
    <span>enviaremos un tiket de compra a su correo electronico</span>
</body>
</html>
