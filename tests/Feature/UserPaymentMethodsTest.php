<?php

namespace Tests\Feature;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPaymentMethodsTest extends TestCase
{
    use RefreshDatabase;
 
     /**
      @test
     */

    public function a_user_can_only_view_active_payment_methods() : void
    {
        $user = User::factory()->create();
        $this->createPaymentMethodStripe();

        $response = $this->get(route('user.show', $user->id));
        $response->assertOk();
        $response->assertViewHas(['paymentMethods' => PaymentMethod::where('is_active', true)->get() ]);
    }

     /**
      @test
     */

    public function a_user_can_add_payment_methods() : void
    {
        $user = User::factory()->create();
        $paymentMethod = $this->createPaymentMethodStripe();

        $this->get(route('user.show', $user->id));

        $response = $this->post(route('user.create.payment_method', [ $user->id, $paymentMethod->id ]));

        $this->assertCount(1, $user->paymentMethods);
        $response->assertStatus(302);
        $response->assertRedirect(route('user.show', $user->id));
    }

     /**
      @test
     */

    public function a_user_can_choose_default_payment_method() : void
    {
        $user = User::factory()->create();
        $stripePaymentMethod = $this->createPaymentMethodStripe();
        $cashPaymentMethod = $this->createPaymentMethodCash();

        $this->get(route('user.show', $user->id));

        $this->post(route('user.create.payment_method', [ $user->id, $stripePaymentMethod->id ]));
        $this->post(route('user.create.payment_method', [ $user->id, $cashPaymentMethod->id ]));

        $response = $this->post(route('user.update.payment_method', [ $user->id, $cashPaymentMethod->id ]));

    
        $this->assertEquals(2, $user->default_payment_method);
        $response->assertStatus(302);
        
    }

    /**
      @test
     */

    public function a_user_can_delete_a_payment_method() : void
    {
        $user = User::factory()->create();
        $stripePaymentMethod = $this->createPaymentMethodStripe();
        $cashPaymentMethod = $this->createPaymentMethodCash();

        $this->get(route('user.show', $user->id));

        $this->post(route('user.create.payment_method', [ $user->id, $stripePaymentMethod->id ]));
        $this->post(route('user.create.payment_method', [ $user->id, $cashPaymentMethod->id ]));

        $response = $this->post(route('user.delete.payment_method', [ $user->id, $cashPaymentMethod->id ]));

    
        $this->assertCount(1, $user->paymentMethods);
        $this->assertEquals(1, $user->paymentMethods->first()->id);

        $response->assertStatus(302);
        $response->assertRedirect(route('user.show', $user->id));
        
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
