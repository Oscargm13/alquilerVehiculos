<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AXrqHGNlWQ3wEcki7zCOY0QaiUWzMeCmf9wVifnDNpZRj-UPbAnNqN2c8wP9orVEfQdYdNoNgKUZXDUC&currency=EUR"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 50px;
        }

        #paypal-button-container {
            display: flex;
            justify-content: center;
        }

        #formulario {
            visibility: hidden;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Elige una forma de pago</h1>
        <div class="orden" id="paypal-button-container"></div>
        <?php
            if(isset($_POST['fechaInicio'])) {
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFin = $_POST['fechaFin'];
                $matricula = $_POST['matricula'];
                $ciudad = $_POST['ciudad'];
                $precio = $_POST['precio'];
            
                // Resto de tu código en JavaScript para procesar los datos
                echo "
                <div id='formulario'>
                    <input type='text' value='$fechaInicio' id='fechaInicio'>
                    <input type='text' value='$fechaFin' id='fechaFin'>
                    <input type='text' value='$matricula' id='matricula'>
                    <input type='text' value='$ciudad' id='ciudad'>
                    <input type='text' value='$precio' id='precio'>
                </div>
                ";
            }
        ?>
    </div>
    

    <script>
        let hecho = false;
        let fechaInicio = document.getElementById('fechaInicio').value;
        let fechaFin = document.getElementById('fechaFin').value;
        let matricula = document.getElementById('matricula').value;
        let ciudad = document.getElementById('ciudad').value;
        let precio = document.getElementById('precio').value;

        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: precio
                        }
                    }]
                })
            },
            onCancel: function (data) {
                alert('Pago cancelado'),
                    console.log(data)

            },
            onApprove: function (data, actions) {
                actions.order.capture().then(function (detalles) {
                    window.location.href = "guardar_fecha.php?fechaIni=" + fechaInicio + "&fechaFin=" + fechaFin + "&matricula=" +
                        matricula + "&ciudad=" + ciudad + "&precio="+precio+"&idCompra="+data.orderID+"&precio2="+detalles.purchase_units[0].amount.value;
                });
                hecho = true
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
