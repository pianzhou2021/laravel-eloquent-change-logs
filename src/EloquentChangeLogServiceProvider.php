<?php

namespace Pianzhou\EloquentChangeLog;

use Illuminate\Support\ServiceProvider;
use Pianzhou\EloquentChangeLog\Observers\ChangeLogObserver;

class EloquentChangeLogServiceProvider extends ServiceProvider
{
    /**
     * register application services.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->registerMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $modelWatchers  = Config::get('watchers', []);
        collect($modelWatchers)->each(function ($model) {
            $observeClass = app()->make(ChangeLogObserver::class);
            if (class_exists($model)) {
                $model::observe($observeClass);
            }
        });
    }

    /**
     * Register the package migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the package configuration.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/eloquent-change-log.php' => config_path('eloquent-change-log.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/eloquent-change-log.php', 'eloquent-change-log');
    }
}