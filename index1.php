<?php
session_start();

// Si el pago ya se realizó, no permitir regresar aquí
if (isset($_SESSION['pago_exitoso']) && $_SESSION['pago_exitoso'] === true) {
    unset($_SESSION['pago_exitoso']); // Elimina la variable
    header('Location: https://clarity.com.mx/'); // Redirige
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con PayPal - Tarjeta y Pay Later</title>
    <script 
        src="https://www.paypal.com/sdk/js?client-id=ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc&currency=USD&locale=es_MX&buyer-country=US&components=buttons&enable-funding=paylater,card"
        data-sdk-integration-source="developer-studio">
    </script>
    <style>
        .paypal-button-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Selecciona tu método de pago</h2>

    <div class="paypal-button-container" id="paypal-button-paypal"></div>
    <div class="paypal-button-container" id="paypal-button-paylater"></div>
    <div class="paypal-button-container" id="paypal-button-card"></div>

    <script>

        const total = 200; // Monto total a pagar
        const createOrder = () => {
            return fetch('api/create_order_us.php', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                    body: JSON.stringify({
                        amount: total
                    })
            
                })
                .then(res => res.json())
                .then(data => data.id);
        };

        const onApprove = (data) => {
            return fetch(`api/capture_order.php?orderID=${data.orderID}`, {
                method: 'POST'
            })
            .then(res => res.json())
            .then(details => {


                const orderID = details.id;
                const amount = details.purchase_units[0].amount.value;
                const payerName = details.payer.name.given_name;
                const payerSurName = details.payer.name.surname;

                const redirectUrl = "payment-news.php?id=" + orderID + "&amount=" + amount + "&name=" + payerName + "&surname=" + payerSurName;
                // Redirigir a la página de éxito con los parámetros de la transacción
                window.location.href = redirectUrl;

            });
        };

        const onError = (err) => {
            console.error('Error:', err);
            alert('Ocurrió un error. Verifica la consola.');
        };

        // Botón PayPal
        const paypalButton = paypal.Buttons({
            fundingSource: paypal.FUNDING.PAYPAL,
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'rect',
                label: 'paypal'
            },
            createOrder,
            onApprove,
            onError
        });

        if (paypalButton.isEligible()) {
            paypalButton.render('#paypal-button-paypal');
        }

        // Botón Pay Later
        const payLaterButton = paypal.Buttons({
            fundingSource: paypal.FUNDING.PAYLATER,
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'rect',
                label: 'pay'
            },
            createOrder,
            onApprove,
            onError
        });

        if (payLaterButton.isEligible()) {
            payLaterButton.render('#paypal-button-paylater');
        }

        // Botón Tarjeta
        const cardButton = paypal.Buttons({
            fundingSource: paypal.FUNDING.CARD,
            style: {
                layout: 'vertical',
                color: 'black', // Solo "black" o "white"
                shape: 'rect',
                label: 'pay'
            },
            createOrder,
            onApprove,
            onError
        });

        if (cardButton.isEligible()) {
            cardButton.render('#paypal-button-card');
        }
    </script>
</body>
</html>
