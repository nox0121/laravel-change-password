<?php

namespace Vswteam\LaravelChangePassword\Tests;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Vswteam\LaravelChangePassword\ChangePasswordHandler;
use Vswteam\LaravelChangePassword\Tests\Models\User;

class ChangePasswordHandlerTest extends TestCase
{
    /** @var User */
    private $user;

    /** @var Hasher */
    private $hasher;

    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'email' => 'test@example.com',
            'name' => 'test',
        ]);
        $this->hasher = $this->app->make(Hasher::class);
    }

    /** @test */
    public function can_change_password()
    {
        /** arrange */
        $handler = new ChangePasswordHandler($this->hasher, $this->user);
        $account = 'test@example.com';
        $password = '123456';

        /** act */
        $handler->handle($account, $password);

        /** assert */
        $this->assertTrue(true);
    }

    /** @test */
    public function throw_exception_if_account_not_exist()
    {
        /** arrange */
        $this->expectException(ModelNotFoundException::class);

        $handler = new ChangePasswordHandler($this->hasher, $this->user);
        $account = 'abc@example.com';
        $password = '123456';

        /** act */
        $handler->handle($account, $password);

        /** assert */
    }
}
