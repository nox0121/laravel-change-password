<?php

namespace Vswteam\LaravelChangePassword;

interface ChangePasswordHandlerInterface
{
    public function handle(string $account, string $password);
}
