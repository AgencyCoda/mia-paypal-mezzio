<?php

namespace Mia\PayPal;

use Mia\PayPal\Request\PlansCreateRequest;
use Mia\PayPal\Request\PlansGetRequest;
use Mia\PayPal\Request\ProductsCreateRequest;
use Mia\PayPal\Request\ProductsGetRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PaypalHelper
{
    /**
     * Documentation: https://developer.paypal.com/
     * @var string
     */
    protected $clientId = '';
    /**
     * 
     * @var string
     */
    protected $clientSecret = '';
    /**
     * Undocumented variable
     *
     * @var PayPalHttpClient
     */
    protected $client;
    /**
     * 
     * @param string $access_token
     */
    public function __construct($client_id, $client_secret)
    {
        $this->clientId = $client_id;
        $this->clientSecret = $client_secret;
        $this->initClient();
    }
    /**
     * 
     *
     * @return object
     */
    public function getProducts()
    {
        $request = new ProductsGetRequest();
        return $this->client->execute($request)->result;
    }
    /**
     * 
     *
     * @param string $name
     * @param string $description
     * @return object
     */
    public function generateProduct($name, $description)
    {
        $request = new ProductsCreateRequest();
        $request->body = [
            'name' => $name,
            'description' => $description,
            'type' => 'SERVICE',
            'category' => 'SOFTWARE'
        ];
        return $this->client->execute($request)->result;
    }

    public function generatePlan()
    {
        try {
            // Generate request
            $request = new PlansCreateRequest();
            $request->body = [
                'product_id' => 'PLANTEST',
                'name' => 'Plan Test 1',
                'status' => 'ACTIVE',
                'description' => 'First plan test',
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => 'MONTH',
                            'interval_count' => 1,
                        ],

                        "tenure_type" => "REGULAR",
                        "sequence" => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => 99,
                                'currency_code' => 'USD'
                            ]
                        ]
                    ]
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee_failure_action' => 'CANCEL'   
                ]
            ];
            // Call API with your client and get a response for your call
            return $this->client->execute($request);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
            return false;
        }
    }

    public function getPlans()
    {
        try {
            // Generate request
            $request = new PlansGetRequest();
            // Call API with your client and get a response for your call
            return $this->client->execute($request);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
            return false;
        }
    }
    /**
     * Undocumented function
     *
     * @return \PayPalHttp\HttpResponse|boolean
     */
    public function generateOrder()
    {
        $request = new OrdersCreateRequest();
        //$request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "4",
                "amount" => [
                    "value" => "100.00",
                    "currency_code" => "USD"
                ]
            ]]
        ];

        try {
            // Call API with your client and get a response for your call
            return $this->client->execute($request);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    protected function initClient()
    {
        $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }
}