<?php

namespace App\Providers;

use App\Repository\Produto\ProdutoRepositoryInterface;
use App\Repository\Produto\ProdutoRepositoryDatabase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoRepositoryDatabase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
