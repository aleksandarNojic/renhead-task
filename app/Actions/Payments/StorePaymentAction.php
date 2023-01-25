<?php

namespace App\Actions\Payments;

use App\Actions\AbstractAction;

class StorePaymentAction extends AbstractAction
{
    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        return (bool) auth()->user()->payments()->create(
            $this->request->only('total_amount')
        );
    }
}
