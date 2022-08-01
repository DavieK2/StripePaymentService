<?php

namespace App\Providers;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\PaymentMethod;
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
        // $this->app->singleton(PaymentGatewayInterface::class, function($app){
        //     if(!request()->has('payment_method')) abort(400, 'Invalid Payment Method');
            
        //     $paymentGateway = PaymentMethod::findOrFail(request('payment_method'))?->class;
            
        //     return new $paymentGateway();
        // });
    }
}
