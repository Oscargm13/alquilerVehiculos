<?php
    include '../includes/conexion.php';
    $directorioImagen = "../imagenes/imagenes_vehiculos/";

    if(isset($_POST["modelo"])) {
        $marca = $_POST["existe"];
    }
    if(isset($_POST["modelo"])) {
        $modelo = $_POST["modelo"];
        $nimagen = strtolower($_POST["modelo"]).".png";
    }
    if(isset($_POST["tipo"])) {
        $tipo = $_POST["tipo"];
    }
    if(isset($_POST["parking"])) {
        $parking = $_POST["parking"];
    }
    if(isset($_POST["matricula"])) {
        $matricula = $_POST["matricula"];
    }
    //Subir imagen a carpeta
    if($_FILES['imagen']['name']!=""){
    //$imagen = basename($_FILES['imagen']['name']);
    $imagen = strtolower($modelo);
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
            if($tipoArchivo == "png") {
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
    

    $id_modelo = 1;
    $id_modelo_verificado = 1;
    $comprobar = false;

    $query = "SELECT * FROM `Modelos` WHERE 1";

    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }
    echo $modelo. " ";
    echo $marca. "<br>";

    while ($fila = mysqli_fetch_array($consulta)) {
        if($modelo == $fila["model"]&&$marca == $fila["brand"]) {
            echo $fila["model"]. " ";
            echo $fila["brand"];
            $id_modelo_verificado = $fila["id_modelo"];
            $comprobar = true;
            break;
        }else $comprobar = false;
    }
    echo "hola <br>";
    if($comprobar == false) {
        $array = array();
        echo "dentro";
        while ($fila = mysqli_fetch_array($consulta)) {
            array_push($array, $fila["id_modelo"]);
        }
        $id_modelo_verificado = verificarModelo($id_modelo, $array);
    }
    echo "<h1>Datos de registro enviados</h1>";
    echo "modelo: ". $modelo. "<br> marca: ".$marca. "<br> matricula: ".
    $matricula. "<br> tipo: ".$tipo. "<br> id_modelo: ".$id_modelo_verificado;

    $query = "INSERT INTO `Vehicles`(`model`, `brand`, `license_plate`, `alquilado`, `id_modelo`)
    VALUES ('$modelo','$marca','$matricula','0','$id_modelo_verificado')";

    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }

    $query = "INSERT INTO `Modelos`(`id_modelo`, `model`, `brand`, `imagen`, nombre_tipo)
    VALUES ('$id_modelo_verificado','$modelo','$marca','$nimagen','$tipo')";
    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }

    $query = "INSERT INTO `Distribucion`(`id_parking`, `license_plate`)
    VALUES ('".$parking."','".$matricula."')";
    echo "///////".$parking ." ".$matricula."///////";
    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }

    function verificarModelo($id_modelo, $id_modelos) {
        do {
          // Generar un número aleatorio entre 1 y 1 millón
          $numero_aleatorio = rand(1, 1000000);
      
          // Verificar si el número aleatorio no está presente en $id_modelos
          $existe_en_array = in_array($numero_aleatorio, $id_modelos);
        } while ($existe_en_array);
      
        // Devolver el número aleatorio que no está presente en $id_modelos
        return $numero_aleatorio;
      }
      mysqli_close($conexion);
?>