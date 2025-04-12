<?php
require 'vendor/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

$clientId = 'ARh09wWp1vfDTHP4whr2pwM8iOXQ_ssY7fiXXaFqllTImH9Y0HrEf28P57v7QU4X5Jm3rhDMfC-KbKHc';
$clientSecret = 'EAFPdsvMLu2MRuo73tPOnXrUfWZWjaT5yd1xrtUySdiYV_cjABUyQgHPca963H8X7cywZ-jJ9hVjLim5';

$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

// Leer el body JSON
$data = json_decode(file_get_contents("php://input"), true);

// Asegúrate de que el orderID esté presente
if (!isset($data['orderID'])) {
    echo json_encode(['status' => 'error', 'message' => 'orderID is required']);
    exit;
}

$orderId = $data['orderID'];

// Depuración: Muestra el orderID recibido
echo "Order ID recibido: " . $orderId . "<br>";

// Realiza la solicitud para capturar el pago
$request = new OrdersCaptureRequest($orderId);
$request->prefer('return=representation');

try {
    // Ejecutar la solicitud
    $response = $client->execute($request);

    // Depuración: Ver todo el objeto de respuesta
    var_dump($response);

    // Verifica si la transacción fue exitosa
    if (isset($response->result->purchase_units[0]->payments->captures[0])) {
        $capture = $response->result->purchase_units[0]->payments->captures[0];
        $payer = $response->result->payer;

        // Depuración: Muestra información del pago
        echo "Pago capturado: <br>";
        echo "ID de Transacción: " . $capture->id . "<br>";
        echo "Nombre del pagador: " . $payer->name->given_name . "<br>";

        // Aquí puedes verificar si el pago a meses sin intereses fue aprobado
        // El campo `payment_source` te puede dar detalles sobre el tipo de pago.
        $paymentSource = $capture->payment_source;

        // Enviar la respuesta con los detalles
        echo json_encode([
            'status' => 'success',
            'payer_given_name' => $payer->name->given_name,
            'payment_source' => $paymentSource, // Esto te dará más información sobre cómo se hizo el pago
            'transaction_id' => $capture->id, // Incluye el ID de la transacción capturada
        ]);
    } else {
        // Si no se encuentra la captura, mostrar un error
        throw new Exception("No capture found in the response.");
    }
} catch (HttpException $ex) {
    // Manejo de errores
    echo json_encode(['status' => 'error', 'message' => $ex->getMessage()]);
}
?>
