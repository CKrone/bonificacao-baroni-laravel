<?php

namespace App\Providers;

use App\Repository\RowDeleted\RowDeletedRepositoryDatabase;
use App\Repository\RowDeleted\RowDeletedRepositoryInterface;
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
        $this->app->bind(RowDeletedRepositoryInterface::class, RowDeletedRepositoryDatabase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
