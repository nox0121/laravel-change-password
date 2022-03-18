<?php

namespace Vswteam\LaravelChangePassword\Tests;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Artisan;
use Vswteam\LaravelChangePassword\Tests\Models\User;

class CommandTest extends TestCase
{
    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'email' => 'admin@admin.com',
            'name' => 'test',
        ]);
        $this->hasher = $this->app->make(Hasher::class);
    }

    /** @test */
    public function it_can_change_password()
    {
        Artisan::call('password:change', [
            'account' => 'admin@admin.com',
            'password' => '123456',
        ]);

        $this->assertTrue(true);
    }
}
