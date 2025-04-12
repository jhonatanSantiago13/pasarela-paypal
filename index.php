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
            src="https://www.paypal.com/sdk/js?client-id=ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc&buyer-country=MX&currency=MXN&locale=es_ES&components=buttons"
            data-sdk-integration-source="developer-studio"
        ></script>
</head>
<body>
    <h2>Pagar con PayPal</h2>
    <div id="paypal-button-container"></div>

    <script>
         paypal.Buttons({
    style: {
        shape: "rect",
        layout: "vertical",
        color: "gold",
        label: "pay",
    },
    createOrder: function(data, actions) {
        return fetch('api/create_order.php', {
            method: 'POST'
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
            alert('Pago capturado por: ' + details.payer.name.given_name);
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
    </script>
</body>
</html>
