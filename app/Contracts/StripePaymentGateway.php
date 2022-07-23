<?php

namespace App\Contracts;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class StripePaymentGateway implements PaymentGatewayInterface{

    public function __construct()
    {
        Stripe::setApiKey(config('app.stripe_api_key'));
    }

    public function checkout() : string
    {
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                    'name' => 'T-shirt',
                  ],
                  'unit_amount' => 2000,
                ],
                'quantity' => 1,
              ]],
            'mode' => 'payment',
            'success_url' => route('payment.succesful'),
            'cancel_url' =>  route('payment.cancel'),
          ]);

        return $checkout_session->url;
    }

    public function checkOutWebHook()
    {
        $payload = request()->all();
        $sig_header = request()->header('HTTP_STRIPE_SIGNATURE');
        $endpoint_secret = config('app.stripe_endpoint_secret');
        
        try {
            $event = \Stripe\Webhook::constructEvent(
              $payload, $sig_header, $endpoint_secret
            );
          } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
          } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
          }
          
          function fulfill_order($session) {
         
            Log::info("$session");
            // dd($session);
          }
          
    }
}