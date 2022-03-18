<?php

namespace Vswteam\LaravelChangePassword\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Vswteam\LaravelChangePassword\LaravelChangePasswordServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->migrateDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelChangePasswordServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('auth.providers.users.model', User::class);
        config()->set('app.key', 'base64:'.base64_encode(
            Encrypter::generateKey(config()['app.cipher'])
        ));
    }

    protected function migrateDatabase()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('password')->nullable();
            $table->timestamps();
        });

        return $this;
    }
}
