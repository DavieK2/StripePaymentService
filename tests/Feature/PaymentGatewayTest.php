<?php

namespace Tests\Feature;

use App\Events\CustomerHasCompletedStripeCheckOutEvent;
use App\Listeners\CustomerHasCompletedStripeCheckOutListener;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
   use RefreshDatabase;

     /**
      @test
     */

   public function users_can_checkout()
   {
        $user = User::factory()->create();
        $stripePaymentMethod = $this->createPaymentMethodStripe();
        $cashPaymentMethod = $this->createPaymentMethodCash();

        $response = $this->post(route('payment.checkout', [$user->id, 'payment_method' => $stripePaymentMethod->id]));
        $response->assertStatus(302);

   }

   /**
      @test
     */

   public function stripe_payment()
   {
        $user = User::factory()->create();
        $stripePaymentMethod = $this->createPaymentMethodStripe();
        $response = $this->post(route('payment.checkout', [$user->id, 'payment_method' => $stripePaymentMethod->id]));

        $response->assertRedirectContains('checkout.stripe.com/pay/');
   }


   /**
      @test
     */

    public function stripe_payment_webhook()
    {
        Event::fake([
            CustomerHasCompletedStripeCheckOutEvent::class,
        ]);

        $stripe = new \Stripe\StripeClient(config('app.stripe_api_key'));

        $payment = $stripe->paymentIntents->create([
                'amount' => 500, 
                'currency' => 'gbp', 
                'payment_method' => 'pm_card_visa',
            ]
        );

        $stripe->paymentIntents->confirm(
            $payment['id'],
            ['payment_method' => 'pm_card_visa']
          );
        
        Event::assertListening(CustomerHasCompletedStripeCheckOutEvent::class, CustomerHasCompletedStripeCheckOutListener::class);
    }


     /**
      @test
     */


     public function stripe_refund()
     {
        $this->withoutExceptionHandling();
        $stripe = new \Stripe\StripeClient(config('app.stripe_api_key'));

        $payment = $stripe->paymentIntents->create([
                'amount' => 500, 
                'currency' => 'gbp', 
                'payment_method' => 'pm_card_visa',
            ]
        );

        $stripe->paymentIntents->confirm(
            $payment['id'],
            ['payment_method' => 'pm_card_visa']
          );

        PaymentMethod::factory()->create();
        $payment = Payment::create(['payment_data'  => [ 'payment_intent' => $payment['id']]]);

        
        $response = $this->get(route('refund.store', [1, 'payment_method' => 1 ]));
        
        $this->assertCount(1, Refund::all());

        
     }

   protected function createPaymentMethodStripe(): PaymentMethod
    {
        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'stripe',
            'class' => 'App\Contracts\StripePaymentGateway',
        ]);
        return $paymentMethod;
    }

    protected function createPaymentMethodCash(): PaymentMethod
    {
        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'cash',
            'class' => 'App\Contracts\CashPaymentGateway',
        ]);
        return $paymentMethod;
    }
}
