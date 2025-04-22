<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../PayPalClient.php';

use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

// Validar que se reciba el parámetro orderID
if (!isset($_GET['orderID']) || empty($_GET['orderID'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el parámetro orderID']);
    exit;
}

$orderID = $_GET['orderID'];
$client = PayPalClient::client();

// Crear la solicitud de captura
$request = new OrdersCaptureRequest($orderID);
$request->prefer('return=representation');

try {
    $response = $client->execute($request);
    echo json_encode($response->result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
