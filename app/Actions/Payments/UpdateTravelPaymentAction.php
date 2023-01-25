<?php

namespace App\Actions\Payments;

use App\Actions\AbstractAction;
use App\Models\TravelPayment;
use Illuminate\Http\Request;

class UpdateTravelPaymentAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request, public TravelPayment $travelPayment)
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
        return (bool) $this->travelPayment->update(
            $this->request->only('amount')
        );
    }
}
