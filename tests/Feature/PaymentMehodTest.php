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

    public function a_payment_method_can_be_created()
    {
        $response = $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $this->assertCount(1, PaymentMethod::all());

        $response->assertRedirect('/payment-methods');
    }

    /**
      @test
     */

    public function a_payment_method_can_be_updated()
    {
        $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $paymentMethod = PaymentMethod::first()->id;

        $response = $this->patch("/payment-method/$paymentMethod/update", [
            'payment_method' => 'cash'
        ]);

        $this->assertEquals("cash", PaymentMethod::first()->payment_method);
        $response->assertRedirect('/payment-methods');
    }


     /**
      @test
     */

    public function a_payment_method_can_be_deleted()
    {
        $this->post('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $paymentMethod = PaymentMethod::first()->id;

        $response = $this->delete("/payment-method/$paymentMethod/delete");

        $this->assertCount(1, PaymentMethod::all());
        $response->assertRedirect('/payment-methods');
    }

}
