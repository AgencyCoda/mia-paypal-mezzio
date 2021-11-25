<?php 

declare(strict_types=1);

namespace Mia\PayPal\Factory;

use Mia\PayPal\Helper\PaypalHelper;
use Psr\Container\ContainerInterface;

class PaypalHelperFactory 
{
    public function __invoke(ContainerInterface $container) : PaypalHelper
    {
        // Obtenemos configuracion
        $config = $container->get('config')['paypal'];
        // creamos libreria
        return new PaypalHelper($config['client_id'], $config['client_secret']);
    }
}