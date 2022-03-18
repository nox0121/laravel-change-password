<?php

namespace Vswteam\LaravelChangePassword;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Model;

class ChangePasswordHandler implements ChangePasswordHandlerInterface
{
    /** @var Hasher */
    protected $hasher;

    /** @var Model */
    protected $model;

    /** Construct */
    public function __construct(Hasher $hasher, Model $model)
    {
        $this->hasher = $hasher;
        $this->model = $model;
    }

    /**
     * Execute
     *
     * @param string $account
     * @param string $password
     * @return void
     */
    public function handle(string $account, string $password)
    {
        $user = $this->model->where('email', $account)->firstOrFail();

        $this->setPassword($user, $password);
    }

    /**
     * Set new password for the given user.
     *
     * @param Model $user
     * @param string $password
     */
    protected function setPassword(Model $user, string $password)
    {
        $user->password = $this->hasher->make($password);
        $user->save();
    }
}
