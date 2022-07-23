<?php

namespace App\Providers;

use App\Contracts\StripePaymentGateway;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PaymentGatewayInterface::class, StripePaymentGateway::class);
    }
}
