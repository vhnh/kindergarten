<?php

namespace Vhnh\Kindergarten;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app['router']->aliasMiddleware('kindergarten', Guard::class);
    }
}
