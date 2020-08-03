<?php

namespace Vhnh\Kindergarten;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use UAParser\Parser;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->singleton(Parser::class, function () {
            return Parser::create();
        });
    }

    public function boot()
    {
        $this->app['router']->aliasMiddleware('kindergarten', Guard::class);
    }
}
