<?php

namespace App\Providers;

use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ContactMessageRepository;
use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository($app['em']);
        });

        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class), $app->make(CategoryRepository::class));
        });
        $this->app->bind(CategoryRepository::class, function ($app) {
            return new CategoryRepository($app[EntityManagerInterface::class]);
        });
        $this->app->bind(CartRepository::class, function ($app) {
            return new CartRepository($app[EntityManagerInterface::class]);
        });
        $this->app->bind(CartItemRepository::class, function ($app) {
            return new CartItemRepository($app[EntityManagerInterface::class]);
        });
        $this->app->bind(CouponRepository::class, function ($app) {
            return new CouponRepository($app[EntityManagerInterface::class]);
        });
        $this->app->bind(ContactMessageRepository::class, function ($app) {
            return new ContactMessageRepository($app[EntityManagerInterface::class]);
        });
        $this->app->bind(CartService::class, function ($app) {
            return new CartService(
                $app[CartRepository::class],
                $app[ProductRepository::class]
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
