<?php

namespace App\Actions\Payments;

class StoreTravelPaymentAction extends BaseAction
{
    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        $payment = auth()->user()->travelPayments()->create(
            $this->request->only('amount')
        );

        return (bool) $this->setPayment($payment);
    }
}
