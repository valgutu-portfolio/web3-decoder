<?php

namespace App\Providers;

use App\Repositories\Clients\Contracts\ClientRepository;
use App\Repositories\Clients\EloquentClientRepository;
use App\Repositories\Orders\Contracts\OrderRepository;
use App\Repositories\Orders\EloquentOrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientRepository::class, EloquentClientRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
