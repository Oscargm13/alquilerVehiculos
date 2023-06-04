<?php
    include '../includes/conexion.php';
    $directorioImagen = "../imagenes/dni/";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_FILES['imagen']['name']!=""){
        //$imagen = basename($_FILES['imagen']['name']);
        $imagen = $_POST['dni'];
        $nombreImagen = $imagen . "." . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        
        $archivo = $directorioImagen. $nombreImagen;
        $tipoArchivo = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $validarImagen = getimagesize($_FILES['imagen']['tmp_name']);
        if($validarImagen != false) {
            $size = $_FILES['imagen']['size'];
            // Validando tamaño
            if($size > 500000) {
                echo "La imagen tiene que ser inferior a 500kb";
            }else {
                //validar tipo imagen
                if($tipoArchivo == "png" || $tipoArchivo == "jpg" || $tipoArchivo == "jpeg") {
                    //archivo valido
                    if(move_uploaded_file($_FILES['imagen']['tmp_name'], $archivo)){
                        echo "El archivo fue subido con exito";
                    }else {
                        echo "hubo un error en la subida del archivo";
                    }
                }else {
                    echo "El archivo debe ser png";
                }
            }
        }else {
            echo "El documento no es una imagen";
        }
        }

        $dni = $_POST["dni"];
        $nombre = $_POST["id"];
        $email = $_POST["mail"];
        $pass = md5($_POST["password"]);
        $tlf = $_POST["tlf"];
        $ciudad = $_POST["ciudad"];

        $sql = "INSERT INTO Customers(name_customer, email, phone_number, domicilio, pass, dni, carnet) 
        VALUES ('$nombre','$email','$tlf','$ciudad','$pass','$dni', '$nombreImagen')";

        $consulta = mysqli_query($conexion, $sql);
        if(!$consulta) {
            die("La consulta falló: ".mysqli_error($conexion));
        }else {
            header("Location: ../index.php?mail=$email&password=$pass");
            exit();
        }

    }

    mysqli_close($conexion);
?>