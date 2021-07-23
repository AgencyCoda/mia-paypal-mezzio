<?php

use Mia\PayPal\PaypalHelper;

require '../vendor/autoload.php';

$clientId = 'AaKquvyMZnuKc4QOtnBQI-JXmDDGeLsztBg-73NWDj89PhpZ0gcX85hE5F4iPCPZdfPs2YfdPCZnjI4s';
$clientSecret = 'EOof2YUY9XI8iLSA8bkQD_Gtfv2b6Q6lg7rBUmh8zsZDRGAuV2T0p3roSyGFrGc78F3h-Ufn8QeXmLsg';

$helper = new PaypalHelper($clientId, $clientSecret);
//$order = $helper->generateOrder();
//print_r($order->result->id);

//print_r($helper->createProduct());
//print_r($helper->getProducts());

$productId = 'PROD-6KR10421KP953941S';

//print_r($helper->createPlanYearly($productId, 'Plan Test 1 Year', 'First plan test year', 2870));

//$planId = 'P-0WJ449211D884135FMD4Y2QQ';
//print_r($helper->getPlans());
//exit();

print_r($helper->getBillingAgreement('I-3R0T3BJ91US9'));
exit();

// Event Type: PAYMENT.SALE.COMPLETED - Pago correcto de la subscription