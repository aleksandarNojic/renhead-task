<?php

namespace App\Actions\User;

use App\Actions\AbstractAction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class SetTypeAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(
        Request $request,
        public User $user,
    ) {
        parent::__construct($request);
    }

    /**
     * Prepare the service for execution.
     *
     * @return void
     *
     * @throws Exception
     */
    public function prepare()
    {
        if (!auth()->user()->type === User::ADMIN) {
            throw new Exception('You do not have privilege for this action', 403);
        }
    }

    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        return (bool) $this->user->update([
            'type' => $this->request->type
        ]);
    }
}
