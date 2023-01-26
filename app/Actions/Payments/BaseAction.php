<?php

namespace App\Actions\Payments;

use App\Actions\AbstractAction;
use App\Models\Payment;
use App\Models\TravelPayment;
use Illuminate\Http\Request;

abstract class BaseAction extends AbstractAction
{
    protected $payment;
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request, Payment|TravelPayment $payment = null)
    {
        $this->payment = $payment;
        parent::__construct($request);
    }

    /**
     * Handles the main execution of the service.
     *
     * @throws \Exception
     * @return bool
     */
    abstract public function handle(): bool;

    /**
     * Return fresh payment object
     *
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set fresh payment object
     *
     */
    protected function setPayment(Payment|TravelPayment $payment): Payment|TravelPayment
    {
        return $this->payment = $payment;
    }
}
