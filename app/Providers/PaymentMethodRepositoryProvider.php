<?php

namespace App\Providers;

use App\Repositories\PaymentMethodRepository;
use App\Interfaces\PaymentMethodRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PaymentMethodRepositoryProvider extends ServiceProvider
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
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
    }
}
