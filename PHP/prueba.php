<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/panelAdmin.js"></script>
    <style>
        #enlaces {
            display: flex;
            flex-direction: column;
        }
        a {
            border: 1px solid orangered;
            box-shadow: 0 0 4px rgba(106, 180, 255, 0.5);
            padding: 20px;
            text-decoration: none;
            color: black;
            font-size: 1.7em;
            font-weight: 500;
        }
        a:hover {
            color: orangered;
            font-weight: 600;
        }
        #container {
            width: 60%;
            display: flex;
            flex-direction: column;
            margin: 0 auto;
            border: 1px solid orangered;
        }
        #container *{
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
        }
        #contenedor_alta label {
            font-size: 1.3em;
        }
        #baja {
            display: none;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Tramitar alta</h1>
            <?php
            $conexion = mysqli_connect('localhost','oscar','contraseña','AlquilerVehiculos');
            if($conexion -> connect_error){
                die('Error en la conexion');
            }
            ?>
            <form action="post" id="form_alta">
                <label for="existe" id="lblAlta">Seleccione marca</label>
                <select name="existe" id="existe">
                    <option value="0">--seleccione un marca--</option>
                </select>
                <label for="">Selecciona un modelo</label>
                <select name="modelo" id="modelo">
                <option value="0">--seleccione un modelo--</option>
                </select>
            </form>
    </div>
</body>
</html>