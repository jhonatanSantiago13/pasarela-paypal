<?php
// SDK de PayPal
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
// use PayPalCheckoutSdk\Core\ProductionEnvironment; // Descomenta esto si usas entorno en vivo

class PayPalClient {
    public static function client() {
        // Tus credenciales de PayPal
        $clientId = 'ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc';
        $clientSecret = 'EAFPdsvMLu2MRuo73tPOnXrUfWZWjaT5yd1xrtUySdiYV_cjABUyQgHPca963H8X7cywZ-jJ9hVjLim5';

        // Elegir entorno:
        $environment = new SandboxEnvironment($clientId, $clientSecret); // PRUEBAS
        // $environment = new ProductionEnvironment($clientId, $clientSecret); // PRODUCCIÓN

        return new PayPalHttpClient($environment);
    }
}