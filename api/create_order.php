<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../PayPalClient.php';
/*require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/../PayPalClient.php';  // Asegúrate de que la ruta sea correcta*/


use PayPalCheckoutSdk\Orders\OrdersCreateRequest;


$client = PayPalClient::client();

$request = new OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = [
    "intent" => "CAPTURE",
    "purchase_units" => [[
        "amount" => [
            "currency_code" => "MXN",
            "value" => "3000.00"
        ]
    ]],
    "payment_source" => [
        "paypal" => [
            "experience_context" => [
                "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                "payment_method_selected" => "PAYPAL",
                "user_action" => "PAY_NOW", // Esto ayuda a mostrar "Paga después"
                "return_url" => "https://tu-dominio.com/return",
                "cancel_url" => "https://tu-dominio.com/cancel"
            ]
        ]
    ]
];

try {
    $response = $client->execute($request);
    echo json_encode($response->result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
