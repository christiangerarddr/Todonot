<?php

namespace App\Providers;

use App\Http\Responses\Response;
use App\Http\Responses\ResponseInterface;
use App\Services\TodoService;
use App\Services\TodoServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseInterface::class, Response::class);
        $this->app->bind(TodoServiceInterface::class, TodoService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
