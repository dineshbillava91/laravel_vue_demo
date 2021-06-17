<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->bind(
			\App\Repositories\Category\CategoryRepository::class,
			\App\Repositories\Category\CategoryRepositoryEloquent::class
		);

		$this->app->bind(
			\App\Repositories\Product\ProductRepository::class,
			\App\Repositories\Product\ProductRepositoryEloquent::class
		);

		$this->app->bind(
			\App\Repositories\Cart\CartRepository::class,
			\App\Repositories\Cart\CartRepositoryEloquent::class
		);

		$this->app->bind(
			\App\Repositories\User\UserRepository::class,
			\App\Repositories\User\UserRepositoryEloquent::class
		);

		$this->app->bind(
			\App\Repositories\Order\OrderRepository::class,
			\App\Repositories\Order\OrderRepositoryEloquent::class
		);

		$this->app->bind(
			\App\Repositories\OrderProductMap\OrderProductMapRepository::class,
			\App\Repositories\OrderProductMap\OrderProductMapRepositoryEloquent::class
		);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
