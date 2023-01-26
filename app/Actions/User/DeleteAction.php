<?php

namespace App\Actions\User;

use App\Actions\AbstractAction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DeleteAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request, public User $user)
    {
        parent::__construct($request);
    }

    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        return (bool) $this->user->delete();
    }
}
