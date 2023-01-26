<?php

namespace App\Actions\Payments;

use Exception;

class UpdateTravelPaymentAction extends BaseAction
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
        if ($this->payment->approval) {
            throw new Exception('Can not update when the payment is approved/disapproved', 403);
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
        return (bool) $this->payment->update(
            $this->request->only('amount')
        );
    }
}
