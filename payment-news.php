<?php 

$id = $_GET['id'] ;// ID de la transacción
$amount = $_GET['amount'] ;// Monto de la transacción
$name = $_GET['name'] ;// Nombre del cliente
$surname = $_GET['surname'] ;// Apellido del cliente

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
        }
        p {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Pago Exitoso!</h1>
        <p><strong>ID de la transacción:</strong><?php echo $id; ?></p>
        <p><strong>Monto:</strong><?php echo $amount; ?></p>
        <p><strong>Nombre del cliente:</strong><?php echo $surname; ?></p>
        <p>Gracias por tu compra.</p>
    </div>

    <script>
    // Mantén al usuario en la página actual bloqueando el botón atrás constantemente
    window.onload = function () {
        history.pushState(null, null, location.href);
        setInterval(function () {
            history.pushState(null, null, location.href);
        }, 100); // Actualiza cada 100ms
    };

    window.onpopstate = function () {
        history.pushState(null, null, location.href);
        alert("No puedes regresar a la página anterior.");
    };
</script>
</body>
</html>