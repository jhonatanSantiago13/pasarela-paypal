<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../PayPalClient.php';  // Asegúrate de que esta ruta sea correcta

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

// Obtener el cliente de PayPal
$client = PayPalClient::client();

// Leer monto desde POST (con un valor por defecto en caso de que no venga)
$data = json_decode(file_get_contents("php://input"), true);
$amountValue = isset($data['amount']) ? $data['amount'] : "150.00"; // Valor por defecto si no se proporciona

// Crear la solicitud para la orden
$request = new OrdersCreateRequest();
$request->prefer('return=representation'); // Asegura que la respuesta contenga detalles completos

// Configurar el cuerpo de la solicitud
$request->body = [
    "intent" => "CAPTURE", // El pago se capturará después de la autorización
    "purchase_units" => [[
        "amount" => [
            "currency_code" => "USD", // Asegúrate de que la moneda sea compatible
            "value" => $amountValue       // El monto del pago
        ]
    ]],
    "payment_source" => [
        "paypal" => [
            "experience_context" => [
                "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED", // Preferencia de método de pago
                "payment_method_selected" => "PAYPAL", // Método de pago seleccionado
                "user_action" => "PAY_NOW", // Esto ayuda a mostrar "Paga después" si está habilitado
                "return_url" => "https://clarity.com.mx/", // Reemplaza con la URL real de retorno
                "cancel_url" => "https://clarityperfect.com/mx/"  // Reemplaza con la URL real de cancelación
            ]
        ]
    ]
];

// Ejecutar la solicitud
try {
    $response = $client->execute($request);  // Enviar la solicitud al servidor de PayPal
    echo json_encode($response->result);     // Retornar la respuesta en formato JSON
} catch (Exception $e) {
    http_response_code(500); // Código de error 500 para problemas internos del servidor
    echo json_encode(["error" => $e->getMessage()]); // Devolver mensaje de error
}
