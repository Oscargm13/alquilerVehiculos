<?php
 //$conexion = mysqli_connect('sql202.epizy.com','epiz_34081714','nACDcClx2Nf8Acd','epiz_34081714_AlquilerVehiculos');
$conexion = mysqli_connect('localhost','oscar','contraseña','AlquilerVehiculos');
if($conexion -> connect_error){
    die('Error en la conexion');
};

?>