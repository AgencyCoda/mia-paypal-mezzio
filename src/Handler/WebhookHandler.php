<?php

namespace Mia\PayPal\Handler;

use Mia\Core\Diactoros\MiaJsonErrorResponse;
use Mia\Core\Diactoros\MiaJsonResponse;
use Mia\PayPal\Helper\PaypalHelper;

/**
 * Description of PayHandler
 *
 * @author matiascamiletti
 */
abstract class WebhookHandler extends \Mia\Auth\Request\MiaAuthRequestHandler
{
    /**
     * @var PaypalHelper
     */
    protected $service;

    public function __construct(PaypalHelper $paypal)
    {
        $this->service = $paypal;
    }
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface 
    {
        // Config initial if needed
        $this->configWebhook($request);
        // Get Event type
        $eventType = $this->getParam($request, 'event_type', '');
        // Process Event
        $this->processEvent($eventType, $request);
        // Return response
        return new MiaJsonResponse(true);
    }

    protected function processEvent($type, \Psr\Http\Message\ServerRequestInterface $request)
    {
        if($type == 'PAYMENT.SALE.COMPLETED'){
            // Get Resource
            $resource = $this->getParam($request, 'resource', []);
            // Get Subscription ID
            $subscriptionId = $resource['billing_agreement_id'];
            // Get data of subscription
            $subscription = $this->service->getBillingAgreement($subscriptionId);
            // Process Subscription
            $this->processSubscription($subscriptionId, $subscription);
        }
    }

    protected function processSubscription($subscriptionId, $subscription)
    {

    }

    protected function configWebhook(\Psr\Http\Message\ServerRequestInterface $request)
    {
        
    }
}
