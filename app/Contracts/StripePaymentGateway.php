<?php

namespace App\Contracts;

use App\Events\CustomerHasCompletedStripeCheckOutEvent;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class StripePaymentGateway implements PaymentGatewayInterface{

    public function __construct()
    {
        Stripe::setApiKey(config('app.stripe_api_key'));
    }

    public function checkout(string $userId) : string
    {
        $checkout_session = \Stripe\Checkout\Session::create([
            'client_reference_id' => "$userId",
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

    public function checkoutSessionWebhook() : void
    {

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $endpoint_secret = config('app.stripe_endpoint_secret');
        $event = null;
        
        try {
            $event = \Stripe\Webhook::constructEvent(
              $payload, $sig_header, $endpoint_secret
            );

          } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error("$e");
            http_response_code(400);
            exit();

          } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error("$e");
            http_response_code(400);
            exit();
          }

          // if($event->type === 'checkout.session.completed'){
          //   $this->createPayment($event->data->object);
          // }
          // For Testing
          if( $event->type === 'charge.succeeded'){
            $this->createPayment($event->data->object);
          }
    }

    public function createPayment($data) : void
    {
      Payment::create(['payment_data' => $data]);
      event(new CustomerHasCompletedStripeCheckOutEvent($data));
     
    }

    public function refund(int $paymentId) : void
    {
        $stripe = new \Stripe\StripeClient(config('app.stripe_api_key'));

        $payment = Payment::findOrFail($paymentId);
        try {
            $refundsData = $stripe->refunds->create(['payment_intent' => $payment->payment_data['payment_intent'] ]);
            Refund::create(['refund_data' => $refundsData]);

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error("$e");
        }
       
    }

}