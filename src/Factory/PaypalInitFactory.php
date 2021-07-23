<?php

namespace Mia\PayPal\Factory;

use Mia\PayPal\PaypalHelper;
use Psr\Container\ContainerInterface;

class PaypalInitFactory
{
    public function __invoke(ContainerInterface $container, $requestName)
    {
        // Get service
        $service = $container->get(PaypalHelper::class);
        // Generate class
        return new $requestName($service);
    }
}