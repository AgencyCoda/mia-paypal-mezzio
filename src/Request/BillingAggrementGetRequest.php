<?php

namespace Mia\PayPal\Request;

use PayPalHttp\HttpRequest;

class BillingAggrementGetRequest extends HttpRequest
{
    function __construct($agreementId)
    {
        parent::__construct("/v1/billing/subscriptions/{agreement_id}?", "GET");
        $this->path = str_replace("{agreement_id}", urlencode($agreementId), $this->path);
        $this->headers["Content-Type"] = "application/json";
    }
}