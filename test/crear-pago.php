<?php
require 'vendor/autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// Configuración del SDK
$apiContext = new ApiContext(
    new OAuthTokenCredential(
        'AfMYcMtWq_i1D2JOlPyccVRs6kTtEvjy-IqfDnJd-e8XVhdZjEJN6fkMdmnXJ-GuZkdF7UMkqt-Q86NK',
        'EFZjxHjQDi74HOzn41k_6BEeuhWaHiMtdmzFKPM0ygI7dtxc3oTcnEkm9wyhYXLw7hYdJq1DDKJg8azu'
    )
);

$apiContext->setConfig(['mode' => 'sandbox']);

// Configuración del pago
$payer = new Payer();
$payer->setPaymentMethod("paypal");

$amount = new Amount();
$amount->setCurrency("MXN")->setTotal("3000");

$transaction = new Transaction();
$transaction->setAmount($amount)->setDescription("Pago de prueba");

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("http:8080//localhost/tu_ruta/capturar-pago.php?success=true")
             ->setCancelUrl("http:8080//localhost/tu_ruta/capturar-pago.php?success=false");

$payment = new Payment();
$payment->setIntent("sale")
        ->setPayer($payer)
        ->setTransactions([$transaction])
        ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
    // Redirigir al usuario a PayPal
    header("Location: " . $payment->getApprovalLink());
    exit;
} catch (Exception $ex) {
    echo "Error al crear el pago: " . $ex->getMessage();
}
?>