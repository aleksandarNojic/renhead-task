<?php

namespace App\Actions\Payments;

use App\Actions\AbstractAction;
use App\Models\Payment;
use App\Models\TravelPayment;
use Illuminate\Http\Request;

class DeleteAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request, public Payment|TravelPayment $payment)
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
        $this->payment->approval()->delete();

        return (bool) $this->payment->delete();
    }
}
