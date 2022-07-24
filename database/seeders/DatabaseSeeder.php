<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();

        PaymentMethod::factory()->create();
        PaymentMethod::factory()->create([
            'payment_method' => 'cash',
            'class' => 'App\Contracts\CashPaymentGateway',
        ]);

    }
}
