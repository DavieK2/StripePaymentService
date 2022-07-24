<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
   
    protected $model = PaymentMethod::class;

    public function definition()
    {
        return [
            'payment_method' => 'stripe',
            'class' => 'App\Contracts\StripePaymentGateway',
        ];
    }
}
