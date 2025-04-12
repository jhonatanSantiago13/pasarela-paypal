<?php 


require 'vendor/autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

// Configura tu client ID y secret desde PayPal Developer
$apiContext = new ApiContext(
    new OAuthTokenCredential(
        'AfMYcMtWq_i1D2JOlPyccVRs6kTtEvjy-IqfDnJd-e8XVhdZjEJN6fkMdmnXJ-GuZkdF7UMkqt-Q86NK',
        'EFZjxHjQDi74HOzn41k_6BEeuhWaHiMtdmzFKPM0ygI7dtxc3oTcnEkm9wyhYXLw7hYdJq1DDKJg8azu'
    )
);

// Configura entorno sandbox
$apiContext->setConfig([
    'mode' => 'sandbox',
    'log.LogEnabled' => true,
    'log.FileName' => '../PayPal.log',
    'log.LogLevel' => 'DEBUG'
]);

echo "SDK PayPal en PHP funcionando correctamente";


?>