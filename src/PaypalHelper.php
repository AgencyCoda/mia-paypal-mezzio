<?php

namespace Mia\PayPal;

use Mia\PayPal\Request\BillingAggrementGetRequest;
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
     * @param string $agreementId
     * @return object
     */
    public function getBillingAgreement($agreementId)
    {
        $request = new BillingAggrementGetRequest($agreementId);
        return $this->client->execute($request)->result;
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
    public function createProduct($name, $description)
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
    /**
     *
     * @param string $productId
     * @param string $name
     * @param string $description
     * @param double $amount
     * @return object
     */
    public function createPlanMonthly($productId, $name, $description, $amount)
    {
        return $this->createPlan($productId, $name, $description, $amount, [
            'interval_unit' => 'MONTH',
            'interval_count' => 1,
        ]);
    }
    /**
     *
     * @param string $productId
     * @param string $name
     * @param string $description
     * @param double $amount
     * @return object
     */
    public function createPlanYearly($productId, $name, $description, $amount)
    {
        return $this->createPlan($productId, $name, $description, $amount, [
            'interval_unit' => 'YEAR',
            'interval_count' => 1,
        ]);
    }
    /**
     * 
     *
     * @param string $productId
     * @param string $name
     * @param string $description
     * @param double $amount
     * @param array $frequency
     * @return object
     */
    public function createPlan($productId, $name, $description, $amount, $frequency = [])
    {
        $request = new PlansCreateRequest();
        $request->body = [
            'product_id' => $productId,
            'name' => $name,
            'status' => 'ACTIVE',
            'description' => $description,
            'billing_cycles' => [
                [
                    'frequency' => $frequency,
                    "tenure_type" => "REGULAR",
                    "sequence" => 1,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => $amount,
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
        return $this->client->execute($request)->result;
    }
    /**
     *
     * @return object
     */
    public function getPlans()
    {
        $request = new PlansGetRequest();
        return $this->client->execute($request);
    }
    /**
     * 
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
    /**
     * Init PayPal Client
     *
     * @return void
     */
    protected function initClient()
    {
        $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }
}