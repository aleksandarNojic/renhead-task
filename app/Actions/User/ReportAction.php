<?php

namespace App\Actions\User;

use App\Actions\AbstractAction;
use App\Models\PaymentApproval;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAction extends AbstractAction
{
    /**
     * Constructor.
     *
     * @param Request|null $request
     */
    public function __construct(
        Request $request,
        public User $user,
        private $reportsQuery = null,
    ) {
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
        return (bool) $this->setReportsQuery();
    }

    /**
     * Set reports query which builds sum of users payments and travel payments
     * and only for the records that do not have single DISAPPROVED status
     *
     * Also I am not filtering by APPROVER user type because only APPROVERS can use approve/disapprove actions
     * so if some user gets another type I do not see the reason why we should not see his history
     *
     * @return void
     */
    private function setReportsQuery()
    {
        $this->reportsQuery = User::with([
            'payments' => function ($query) {
                $query->select(
                    'user_id',
                    DB::raw('SUM(total_amount) as payments_total_sum')
                )
                    ->groupBy('user_id')
                    ->whereDoesntHave('approval', function ($query) {
                        $query->where('status', PaymentApproval::DISAPPROVED);
                    });
            },
            'travelPayments' => function ($query) {
                $query->select(
                    'user_id',
                    DB::raw('SUM(amount) as travel_payments_total_sum')
                )->groupBy('user_id')
                    ->whereDoesntHave('approval', function ($query) {
                        $query->where('status', PaymentApproval::DISAPPROVED);
                    });
            }
        ])
            ->select('users.id', 'users.email')
            ->when($this->user->id, function ($query) {
                return $query->where('users.id', $this->user->id);
            });
    }

    /**
     * Return prepared query
     */
    public function getReportQuery()
    {
        return $this->reportsQuery;
    }
}
