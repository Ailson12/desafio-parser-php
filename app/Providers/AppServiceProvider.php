<?php

namespace App\Providers;

use App\Domain\Repositories\IProductRepository;
use App\Infra\Persistence\Repositories\ProductRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
