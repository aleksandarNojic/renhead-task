<?php

namespace App\Actions\Auth;

use App\Actions\AbstractAction;
use App\Models\User;
use Illuminate\Http\Request;

abstract class AuthAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request, private $token = null)
    {
        parent::__construct($request);
    }

    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    abstract public function handle(): bool;


    /**
     * Return generated token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Generate users roken
     *
     * @param User $user
     * @return string
     */
    protected function generateToken(User $user): void
    {
        $user->tokens()->delete();

        $this->token = $user->createToken('auth_token')->plainTextToken;
    }
}
