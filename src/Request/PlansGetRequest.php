<?php

namespace Mia\PayPal\Request;

use PayPalHttp\HttpRequest;

class PlansGetRequest extends HttpRequest
{
    function __construct()
    {
        parent::__construct("/v1/billing/plans?", "GET");
        $this->headers["Content-Type"] = "application/json";
    }
}