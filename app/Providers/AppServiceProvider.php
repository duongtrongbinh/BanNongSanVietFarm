<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Http\Repositories\RepositoryInterface::class,
            \App\Http\Repositories\Repository::class,
            \App\Http\Pipelines\PipelineFactory::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Validator::extend('requiredexists', function ($attribute, $value, $parameters, $validator) {
            $model = array_shift($parameters);
            $column = array_shift($parameters) ?: 'id';
            return $value && (bool) $model::where($column, $value)->count();
        });
    }
}
