<?php

namespace MikeRice\Stateful;

use Illuminate\Support\ServiceProvider;

class StatefulServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['events']->listen('eloquent.creating*', function ($model) {
            if ($model instanceof StatefulInterface) {
                $model->setInitialState();
            }
        });
    }
}
