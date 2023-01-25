<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginAction extends AuthAction
{
    /**
     * Prepare the service for execution.
     *
     * @return void
     *
     * @throws AppException
     */
    public function prepare()
    {
        $attr = $this->request->only([
            'email',
            'password'
        ]);

        if (!Auth::attempt($attr)) {
            throw new Exception('Bad Credentials', 401);
        }
    }

    /**
     * Handles the main execution of the service.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $user = User::where('email', $this->request->email)->firstOrFail();

        return (bool) $this->generateToken($user);
    }
}
