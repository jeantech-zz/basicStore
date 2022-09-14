<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\PaymentGateways\PaymentGatewayContract;
use App\PaymentGateways\Placetopay;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(PaymentGatewayContract::class, Placetopay::class);
    }
}
