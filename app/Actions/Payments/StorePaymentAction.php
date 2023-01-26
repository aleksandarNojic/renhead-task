<?php

namespace App\Actions\Payments;

class StorePaymentAction extends BaseAction
{
    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    public function handle(): bool
    {
        $payment = auth()->user()->payments()->create(
            $this->request->only('total_amount')
        );

        return (bool) $this->setPayment($payment);
    }
}
