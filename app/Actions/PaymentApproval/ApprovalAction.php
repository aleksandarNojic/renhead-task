<?php

namespace App\Actions\PaymentApproval;

use App\Actions\AbstractAction;
use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ApprovalAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(
        Request $request,
        public Payment|TravelPayment $payment,
        public string $approvalStatus
    ) {
        parent::__construct($request);
    }

    /**
     * Prepare the service for execution.
     *
     * @return void
     *
     * @throws Exception
     */
    public function prepare()
    {
        if (!auth()->user()->type === User::APPROVER) {
            throw new Exception('You do not have privilege for this action', 403);
        }

        if (!in_array($this->approvalStatus, PaymentApproval::STASUES)) {
            throw new Exception('Status should be one of those: ' . implode(',', PaymentApproval::STASUES));
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
        $approval = $this->payment->approval;

        if ($approval) {
            $approval->update([
                'status' => $this->approvalStatus
            ]);
        } else {
            $this->payment->approval()->create(
                [
                    'status' => $this->approvalStatus,
                    'user_id' => auth()->user()->id
                ]
            );
        }

        return (bool) $this->payment->approval;
    }
}
