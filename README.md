<!-- importar proyecto de git a PC -->
git remote add origin https://github.com/jhonatanSantiago13/pasarela-paypal.git
git branch -M main
git push -u origin main

<!-- PayPalClient.php -->
<!-- colocar las credenciales de la app -->
$clientId = 'PAYPAL_CLIENT_ID';
$clientSecret = 'EAFPdsvMLu2MRuo73tPOnXrUfWZWjaT5yd1xrtUySdiYV_cjABUyQgHPca963H8X7cywZ-jJ9hVjLim5';

<!-- index.php -->
<!-- colocar el client id en la url del SDK -->

<script
            src="https://www.paypal.com/sdk/js?client-id=PAYPAL_CLIENT_ID&buyer-country=MX&currency=MXN&locale=es_ES&components=buttons"
            data-sdk-integration-source="developer-studio"
        >
</script>