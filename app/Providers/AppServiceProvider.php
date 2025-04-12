<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\Product\ProductRepository;
use App\Interfaces\User\UserRepositoryInterface;
use App\Repositories\Attachment\AttachmentRepository;
use App\Interfaces\Product\ProductRepositoryInterface;
use App\Interfaces\Attachment\AttachmentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
