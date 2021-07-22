<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Category\ICategoryRepository::class,
            \App\Repositories\Category\CategoryRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Product\IProductRepository::class,
            \App\Repositories\Product\ProductRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProductImage\IProductImageRepository::class,
            \App\Repositories\ProductImage\ProductImageRepository::class
        );

        $this->app->singleton(
            \App\Repositories\User\IUserRepository::class,
            \App\Repositories\User\UserRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Order\IOrderRepository::class,
            \App\Repositories\Order\OrderRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Cart\ICartRepository::class,
            \App\Repositories\Cart\CartRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
