<?php

namespace App\Providers;

use App\Repositories\Brands\BrandDBRepository;
use App\Repositories\Brands\BrandInterface;
use App\Repositories\Categories\CategoryEloquentRepository;
use App\Repositories\Categories\CategoryInterface;
use App\Repositories\Products\ProductDBRepository;
use App\Repositories\Products\ProductInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
//        $this->app->bind(ProductInterface::class, ProductDBRepository::class);
        $this->app->bind(ProductInterface::class, ProductDBRepository::class);
        $this->app->bind(BrandInterface::class, BrandDBRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryEloquentRepository::class);
    }
}
