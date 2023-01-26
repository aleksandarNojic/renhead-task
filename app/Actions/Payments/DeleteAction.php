<?php

namespace App\Actions\Payments;

class DeleteAction extends BaseAction
{
    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        $this->payment->approval()->delete();

        return (bool) $this->payment->delete();
    }
}
