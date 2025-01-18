<?php

namespace App\Providers;

use App\Services\Contracts\OrderServiceContract;
use App\Services\Contracts\PaymentServiceContract;
use App\Services\Services\OrderService;
use App\Services\Services\PaymentService;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceContract::class, OrderService::class);
        $this->app->bind(PaymentServiceContract::class, PaymentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
