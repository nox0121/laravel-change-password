<?php

namespace Vswteam\LaravelChangePassword;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider;
use Vswteam\LaravelChangePassword\Commands\LaravelChangePasswordCommand;

class LaravelChangePasswordServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LaravelChangePasswordCommand::class,
            ]);
        }
    }

    public function register()
    {
        $config = $this->app->make('config');

        $this->app->bind(ChangePasswordHandlerInterface::class, function ($app) use ($config) {
            return new ChangePasswordHandler(
                $app->make(Hasher::class),
                new $config['auth.providers.users.model']()
            );
        });
    }
}
