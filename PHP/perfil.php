<!DOCTYPE html>
<html>
<head>
  <title>Mi Perfil</title>
  <link rel="stylesheet" type="text/css" href="../estilos/perfil.css">
</head>
<body>
  <div class="perfil">
    <h1>Mi Perfil</h1>
    <img src="../imagenes/perfil.webp" alt="Imagen de perfil">
    <?php
    include_once '../includes/user.php';
    include_once '../includes/userSession.php';

    $userSession = new UserSession();
    $user = new User();
    $usuario = $userSession->getCurrentUser();

    include "../includes/conexion.php";
    $query = "SELECT * FROM `Customers` WHERE Customers.email = '$usuario';";
    $consulta = mysqli_query($conexion, $query);
    if(!$consulta) {
        die("La consulta falló: ".mysqli_error($conexion));
    }
    while ($fila = mysqli_fetch_array($consulta)) {
        $nombre = $fila['name_customer'];
        $numero = $fila['phone_number'];
        $domicilio = $fila['domicilio'];
    }
    $perfil = 'perfil=""';
    echo "
        <h2>Nombre:</h2>
        <p>$nombre</p>
        <h2>Correo:</h2>
        <p>$usuario</p>
        <h2>numero de telefono:</h2>
        <p>$numero</p>
        "; ?>
        <?php echo "<br>
        <button name='perfil'>Modificar perfil</button>";
    ?>
    
  </div>
</body>
</html>