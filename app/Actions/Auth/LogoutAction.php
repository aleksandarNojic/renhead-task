<?php

namespace App\Actions\Auth;

class LogoutAction extends AuthAction
{
    /**
     * Handles the main execution of the service.
     *
     * @return bool
     */
    public function handle(): bool
    {
        return (bool) auth()->user()->tokens()->delete();;
    }
}
