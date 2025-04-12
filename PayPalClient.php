<?php
// Sandox mode
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

// Live mode
/*use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;*/


class PayPalClient {
    public static function client() {
        // Puedes poner tus credenciales directamente:
        $clientId = 'ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc';
        $clientSecret = 'EAFPdsvMLu2MRuo73tPOnXrUfWZWjaT5yd1xrtUySdiYV_cjABUyQgHPca963H8X7cywZ-jJ9hVjLim5';

        // O bien cargarlos desde variables de entorno:
        // $clientId = getenv("PAYPAL_CLIENT_ID");
        // $clientSecret = getenv("PAYPAL_SECRET");

        // live mode
        // $environment = new ProductionEnvironment($clientId, $clientSecret);


        $environment = new SandboxEnvironment($clientId, $clientSecret);
        return new PayPalHttpClient($environment);
    }
}


/*namespace PayPalCheckoutSdk\Core;

use PayPalHttpClient;
use SandboxEnvironment; // Si usas el entorno de Sandbox
// use LiveEnvironment;    // Si usas el entorno en producción*/

// use PayPalCheckoutSdk\Core\SandboxEnvironment;
// use PayPalCheckoutSdk\Core\PayPalHttpClient;

// //Fatal error: Uncaught Error: Call to undefined method PayPalCheckoutSdk\Core\PayPalHttpClient::getConfig() in C:\AppServ\www\pasarela-paypal\PayPalClient.php:51 Stack trace: #0 C:\AppServ\www\pasarela-paypal\api\create_order.php(10): PayPalClient::client() #1 {main} thrown in C:\AppServ\www\pasarela-paypal\PayPalClient.php on line 51

// class PayPalClient

// {
//     // Configuración del entorno (Sandbox o Live)
//     public static function client()
//     {
//         $clientId = 'ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc';
//         $clientSecret = 'EAFPdsvMLu2MRuo73tPOnXrUfWZWjaT5yd1xrtUySdiYV_cjABUyQgHPca963H8X7cywZ-jJ9hVjLim5';

//         // Usa el entorno de Sandbox para pruebas, usa LiveEnvironment para producción
//         $environment = new SandboxEnvironment($clientId, $clientSecret); 

//         $client = new PayPalHttpClient($environment);

//         // Desactivar la verificación SSL (solo para pruebas)
//         $client->getConfig()->set('http.CURLOPT_SSL_VERIFYPEER', false);  // Desactivar verificación SSL

//         return $client;
//     }
// }
