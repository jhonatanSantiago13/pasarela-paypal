<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con PayPal - Tarjeta - Pay Later</title>
    <script
        src="https://www.paypal.com/sdk/js?client-id=ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc&currency=MXN&locale=es_ES&components=buttons&enable-funding=paylater,card"
        data-sdk-integration-source="developer-studio"
    ></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f2f2f2;
        }
        h2 {
            color: #333;
        }
        .paypal-buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2>Selecciona tu forma de pago</h2>

    <div class="paypal-buttons">
        <!-- Pay Later -->
        <div id="paylater-button-container"></div>

        <!-- PayPal -->
        <div id="paypal-button-container"></div>

        <!-- Tarjeta -->
        <div id="card-button-container"></div>
    </div>

    <script>
        // Función general para crear órdenes
        const createOrder = () => {
            return fetch('api/create_order.php', {
                method: 'POST'
            })
            .then(res => res.json())
            .then(order => order.id);
        };

        // Función general para capturar órdenes
        const captureOrder = (orderID) => {
            return fetch(`api/capture_order.php?orderID=${orderID}`, {
                method: 'POST'
            })
            .then(res => res.json())
            .then(details => {
                alert('Pago capturado por: ' + details.payer.name.given_name);
            });
        };

        // Pay Later
        if (paypal.FUNDING.PAYLATER) {
            paypal.Buttons({
                fundingSource: paypal.FUNDING.PAYLATER,
                style: {
                    layout: 'vertical',
                    color: 'blue',
                    label: 'paylater',
                    shape: 'rect'
                },
                createOrder: createOrder,
                onApprove: (data) => captureOrder(data.orderID),
                onError: (err) => console.error('Error Pay Later:', err)
            }).render('#paylater-button-container');
        }

        // PayPal
        paypal.Buttons({
            fundingSource: paypal.FUNDING.PAYPAL,
            style: {
                layout: 'vertical',
                color: 'gold',
                label: 'pay',
                shape: 'rect'
            },
            createOrder: createOrder,
            onApprove: (data) => captureOrder(data.orderID),
            onError: (err) => console.error('Error PayPal:', err)
        }).render('#paypal-button-container');

        // Tarjeta de crédito o débito
        if (paypal.FUNDING.CARD) {
            paypal.Buttons({
                fundingSource: paypal.FUNDING.CARD,
                style: {
                    layout: 'vertical',
                    color: 'silver',
                    label: 'pay',
                    shape: 'rect'
                },
                createOrder: createOrder,
                onApprove: (data) => captureOrder(data.orderID),
                onError: (err) => console.error('Error Tarjeta:', err)
            }).render('#card-button-container');
        }
    </script>
</body>
</html>
