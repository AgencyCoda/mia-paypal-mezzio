<?php

use Mia\PayPal\PaypalHelper;

require '../vendor/autoload.php';

$clientId = 'AaKquvyMZnuKc4QOtnBQI-JXmDDGeLsztBg-73NWDj89PhpZ0gcX85hE5F4iPCPZdfPs2YfdPCZnjI4s';
$clientSecret = 'EOof2YUY9XI8iLSA8bkQD_Gtfv2b6Q6lg7rBUmh8zsZDRGAuV2T0p3roSyGFrGc78F3h-Ufn8QeXmLsg';

$helper = new PaypalHelper($clientId, $clientSecret);
//$order = $helper->generateOrder();
//print_r($order->result->id);

//print_r($helper->generateProduct());
print_r($helper->getProducts());

$productId = 'PROD-6KR10421KP953941S';

//print_r($helper->generatePlan());
//print_r($helper->getPlans());
exit();