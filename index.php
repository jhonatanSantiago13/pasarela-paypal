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
    <title>Pago con PayPal - Pay Later</title>
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=AfMYcMtWq_i1D2JOlPyccVRs6kTtEvjy-IqfDnJd-e8XVhdZjEJN6fkMdmnXJ-GuZkdF7UMkqt-Q86NK&currency=MXN&components=buttons,funding-eligibility"></script> -->
    <!-- <script
            src="https://www.paypal.com/sdk/js?client-id=ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc&buyer-country=US&currency=USD&locale=es_ES&components=buttons&enable-funding=venmo,paylater,card"
            data-sdk-integration-source="developer-studio"
        ></script> -->
    <script
            src="https://www.paypal.com/sdk/js?client-id=ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc&buyer-country=MX&currency=MXN&locale=es_MX&components=buttons"
            data-sdk-integration-source="developer-studio"
        ></script>
</head>
<body>
    <h2>Pagar con PayPal</h2>
    <div id="paypal-button-container"></div>

    <script>
        const total = 4000; // Monto total a pagar (puedes cambiarlo según tus necesidades)
         paypal.Buttons({
    style: {
        shape: "rect",
        layout: "vertical",
        color: "gold",
        label: "pay",
    },
    createOrder: function(data, actions) {
        return fetch('api/create_order.php', {
            method: 'POST',
            headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: total
                })

        })
        .then(res => res.json())
        .then(order => order.id);
    },
    onApprove: function(data, actions) {
        return fetch(`api/capture_order.php?orderID=${data.orderID}`, {
            method: 'POST'
        })
        .then(res => res.json())
        .then(details => {

            const orderID = details.id;
            const amount = details.purchase_units[0].amount.value;
            const payerName = details.payer.name.given_name;
            const payerSurName = details.payer.name.surname;
            
           
            // alert('Pago capturado por: ' + details.payer.name.given_name);

            const redirectUrl = "payment-news.php?id=" + orderID + "&amount=" + amount + "&name=" + payerName + "&surname=" + payerSurName;
            // Redirigir a la página de éxito con los parámetros de la transacción
            window.location.href = redirectUrl;
        });
    },
    onCancel: function(data) {
        alert('Pago cancelado.');
    },
    onError: function(err) {
        console.error('Error:', err);
        alert('Ocurrió un error. Verifica la consola.');
    }
}).render('#paypal-button-container');

/* probar https://clarity.com.mx/manager/tools/pasarela-paypal/index.php */

    </script>
</body>
</html>
