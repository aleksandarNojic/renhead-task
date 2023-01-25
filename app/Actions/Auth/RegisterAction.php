<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction extends AuthAction
{
    /**
     * Handles the main execution of the service.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $data = array_merge(
            $this->request->only([
                'first_name',
                'last_name',
                'email',
            ]),
            ['password' => Hash::make($this->request->password)]
        );

        $user = User::create($data);

        return (bool) $this->generateToken($user);
    }
}
