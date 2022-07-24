<?php

namespace Tests\Feature;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
 
     /**
      @test
     */

    public function a_payment_method_can_be_created() : void
    {
        $response = $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $this->assertCount(1, PaymentMethod::all());

        $response->assertStatus(302);
        $response->assertRedirect(route('payment.index'));
    }

    /**
      @test
     */

    public function a_payment_method_can_be_updated() : void
    {
        $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $paymentMethod = PaymentMethod::first()->id;

        $response = $this->patch("/payment-method/$paymentMethod/update", [
            'payment_method' => 'cash'
        ]);

        $this->assertEquals("cash", PaymentMethod::first()->payment_method);
        $response->assertRedirect(route('payment.index'));
    }


     /**
      @test
     */

    public function a_payment_method_can_be_deleted() : void
    {
        $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $paymentMethod = PaymentMethod::first()->id;

        $response = $this->delete("/payment-method/$paymentMethod/delete");

        $this->assertCount(0, PaymentMethod::all());
        $response->assertRedirect(route('payment.index'));
    }

     /**
      @test
     */

    public function a_payment_method_that_has_been_implemented_can_be_activated() : void
    {
        $this->get(route('payment.index'));

        $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $paymentMethod = PaymentMethod::first();

        $response = $this->patch("/payment-method/$paymentMethod->id/toggle");

        $this->assertTrue(boolval($paymentMethod->fresh()->is_active));

        $response->assertRedirect(route('payment.index'));
    }


     /**
      @test
     */

    public function a_payment_method_that_has_been_implemented_can_be_deactivated() : void
    {
        $this->get(route('payment.index'));

        $this->post('/payment-method/create', [
            'payment_method' => 'stripe',
            'is_active' => 1,
        ]);

        $paymentMethod = PaymentMethod::first();

        $this->patch("/payment-method/$paymentMethod->id/toggle");

        $response = $this->patch("/payment-method/$paymentMethod->id/toggle");

        $this->assertFalse(boolval($paymentMethod->fresh()->is_active));

        $response->assertRedirect(route('payment.index'));
    }


     /**
      @test
     */

    public function a_payment_method_that_has_not_been_implemented_cannot_be_activated() : void
    {
        $this->get(route('payment.index'));

        $this->post('/payment-method/create', [
            'payment_method' => 'bank',
            'is_active' => 1,
        ]);

        $paymentMethod = PaymentMethod::first();

        $response = $this->patch("/payment-method/$paymentMethod->id/toggle");

        $this->assertFalse(boolval($paymentMethod->fresh()->is_active));

        $response->assertRedirect(route('payment.index'));
    }


}
