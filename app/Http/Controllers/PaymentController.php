<?php

namespace App\Http\Controllers;

use App\Actions\PaymentApproval\ApprovalAction;
use App\Actions\Payments\DeleteAction;
use App\Actions\Payments\StorePaymentAction;
use App\Actions\Payments\UpdatePaymentAction;
use App\Http\Requests\Payment\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\PaymentApproval;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return PaymentResource::collection(Payment::with('user')->paginate($request->get('per_page', 1)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PaymentRequest  $request
     */
    public function store(PaymentRequest $request)
    {
        $action = new StorePaymentAction($request);
        return $action->run();
    }

    /**
     * Display the specified resource.
     *
     * @param  Payment  $payment
     * @return PaymentResource
     */
    public function show(Payment $payment): PaymentResource
    {
        return new PaymentResource($payment->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentRequest  $request
     * @param  Payment  $payment
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $action = new UpdatePaymentAction($request, $payment);
        return $action->run();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Payment  $payment
     */
    public function destroy(Request $request, Payment $payment)
    {
        $action = new DeleteAction($request, $payment);
        return $action->run();
    }

    /**
     * Approve the payment.
     *
     * @param  Payment  $payment
     */
    public function approve(Request $request, Payment $payment)
    {
        $action = new ApprovalAction($request, $payment, PaymentApproval::APPROVED);
        return $action->run();
    }

    /**
     * Disapprove the payment.
     *
     * @param  Payment  $payment
     */
    public function disapprove(Request $request, Payment $payment)
    {
        $action = new ApprovalAction($request, $payment, PaymentApproval::DISAPPROVED);
        return $action->run();
    }
}
