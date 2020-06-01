<?php

namespace App\Providers;

use App\Helpers\Trans;
use Illuminate\Database\Eloquent\FactoryBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Register helper
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }

        // Trait
        $this->app->bind('trans', function () {
            return new Trans();
        });

        // if ($this->app->isLocal()) {
        //     $this->app->register(TelescopeServiceProvider::class);
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::include('components.input', 'input');
        Blade::include('components.checkbox', 'checkbox');
        Blade::include('components.inline-input', 'inlineInput');
        Blade::include('components.class_department_group', 'class_department_group');
        Blade::include('components.class_department_group_confirm', 'class_department_group_confirm');
        Blade::include('components.confirm', 'confirm');

        $loader = AliasLoader::getInstance();
        $loader->alias('Trans', \App\Facades\Trans::class);

        if (env('APP_DEBUG')) {
            DB::listen(function ($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql.' ['.implode(', ', $query->bindings).']'.PHP_EOL
                );
            });
        }

        FactoryBuilder::macro('withoutEvents', function () {
            $this->class::flushEventListeners();

            return $this;
        });

        View::composer('admin.*', function ($view) {
            // TODO: Increasing performance
            if (!View::shared('hsp_title') && isset($view->title)) {
                View::share('hsp_title', $view->title);
            }
        });
    }
}
