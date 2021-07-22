<?php

namespace Mia\PayPal\Request;

use PayPalHttp\HttpRequest;

class PlansCreateRequest extends HttpRequest
{
    function __construct()
    {
        parent::__construct("/v1/billing/plans", "POST");
        $this->headers["Content-Type"] = "application/json";
    }

    public function payPalRequestId($id)
    {
        $this->headers["PayPal-Request-Id"] = $id;
    }
    
    public function prefer($prefer)
    {
        $this->headers["Prefer"] = $prefer;
    }
}