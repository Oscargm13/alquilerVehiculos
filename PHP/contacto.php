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
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        textarea,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box; /* Fix textarea overflowing */
        }

        input[type="submit"] {
            background-color: #E74C3C;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #CB4335;
        }
    </style>
</head>
<body>
    <h1>Contactenos </h1>
    <form action="contacto.php" method="post">
        <textarea name="mss" id="mss" cols="30" rows="10" placeholder="Escribe tu mensage y te contactaremos con la mayor brevedad"></textarea>
        <input type="submit" name="enviar">
    </form>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
include_once '../includes/user.php';
include_once '../includes/userSession.php';

$userSession = new UserSession();
$user = new User();

$usuario = $userSession->getCurrentUser();
                    
if(isset($_POST['enviar'])) {
    //Load Composer's autoloader
                    require '../phpMailer/Exception.php';
                    require '../phpMailer/PHPMailer.php';
                    require '../phpMailer/SMTP.php';
                    
                    $mail = new PHPMailer(true);

                    try {

                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.office365.com';                    
                        $mail->SMTPAuth   = true;                                   
                        $mail->Username   = 'clienteejemploalquiler@outlook.es';
                        $mail->Password   = 'clienteAlquiler';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        //Recipients
                        $mail->setFrom('clienteejemploalquiler@outlook.es', 'Cliente Autorent');
                        $mail->addAddress('alquilervehiculosprueba@outlook.es', 'usuario');


                        //Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Asunto';
                        $mail->Body    = $_POST['mss']."<br> Mensage enviado por: ".$usuario;
                        $mail->AltBody = 'contenido';

                        $mail->send();
                        echo 'Message has been sent';
                        header("Location: ../index.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
}
                    
?>
</body>
</html>
