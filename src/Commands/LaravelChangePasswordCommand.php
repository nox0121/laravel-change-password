<?php

namespace Vswteam\LaravelChangePassword\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Vswteam\LaravelChangePassword\ChangePasswordHandlerInterface;

class LaravelChangePasswordCommand extends Command
{
    protected $signature = 'password:change
        {account : The account of the user}
        {password : The password of the user}';

    protected $description = 'Change User password';

    /** @var ChangePasswordHandlerInterface */
    protected $handler;

    /** Construct */
    public function __construct(
        ChangePasswordHandlerInterface $handler
    ) {
        parent::__construct();

        $this->handler = $handler;
    }

    /** Execute */
    public function handle()
    {
        $account = $this->argument('account');
        $password = $this->argument('password');

        try {
            $this->handler->handle($account, $password);
        } catch (ModelNotFoundException $e) {
            $this->error('Account not found exception: ', $e->getMessage());
        } catch (Exception $e) {
            $this->error('Unexpected error: ', $e->getMessage());
        }

        $this->comment('Password already changed.');
    }
}
