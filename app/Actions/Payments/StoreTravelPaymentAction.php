<?php

namespace App\Actions\Payments;

use App\Actions\AbstractAction;

class StoreTravelPaymentAction extends AbstractAction
{
    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        return (bool) auth()->user()->travelPayments()->create(
            $this->request->only('amount')
        );
    }
}
