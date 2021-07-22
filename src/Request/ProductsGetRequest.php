<?php

namespace Mia\PayPal\Request;

use PayPalHttp\HttpRequest;

class ProductsGetRequest extends HttpRequest
{
    function __construct()
    {
        parent::__construct("/v1/catalogs/products?", "GET");
        $this->headers["Content-Type"] = "application/json";
    }
}