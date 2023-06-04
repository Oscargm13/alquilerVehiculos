<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilosLogin.css">
</head>
<body>
    
    <h1>Inicio de sesion</h1>

    <div id="container">
        <form action="../index.php" method="post">

            

            <label for="mail">Cuenta de correo</label>
            <input type="text" name="mail" id="mail" class="input" value="oscar@gmail.com" required>

            <label for="password">Contraseña del usuario</label>
            <input type="password" name="password" id="password" class="input" required>
             
            <span id="error" style="color: red; margin: 10px;">
                <?php
                    if(isset($errorLogin)){
                        echo $errorLogin;
                    }
                ?>
            </span>
            <button type="submit" id="btn" name="enviar">Siguiente</button><p id="error"></p>

        </form>
        <a href="login.html">No estoy registrado</a>
    </div>
</body>
</html>