<?php
    include '../includes/conexion.php';
    $query = "DELETE FROM `Vehicles` WHERE license_plate='".$_POST["matricula"]."';";
    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }
    $query = "DELETE FROM `Distribucion` WHERE license_plate='".$_POST["matricula"]."';";
    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }else {
        header("Location: ../html/panelAdmin.html");
        exit();
    }
    mysqli_close($conexion);
?>