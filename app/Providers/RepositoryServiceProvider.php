<?php

namespace Delivery\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Delivery\Repositories\CategoryRepository',
            'Delivery\Repositories\CategoryRepositoryEloquent'
        );
    }
}
