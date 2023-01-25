<?php

namespace App\Actions\Payments;

use App\Actions\AbstractAction;
use App\Models\Payment;
use Illuminate\Http\Request;

class UpdatePaymentAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request, public Payment $payment)
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
        return (bool) $this->payment->update(
            $this->request->only('total_amount')
        );
    }
}
