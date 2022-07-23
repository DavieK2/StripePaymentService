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
        $response = $this->patch('/payment-method/create', [
            'payment_method' => 'stripe'
        ]);

        $this->assertCount(1, PaymentMethod::all());

        $response->assertRedirect('/payment-methods');
    }
}
