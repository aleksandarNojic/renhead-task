<?php

namespace App\Http\Controllers;

use App\Actions\PaymentApproval\ApprovalAction;
use App\Actions\Payments\DeleteAction;
use App\Actions\Payments\StoreTravelPaymentAction;
use App\Actions\Payments\UpdateTravelPaymentAction;
use App\Http\Requests\TravelPayment\TravelPaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TravelPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return PaymentResource::collection(TravelPayment::with('user')->paginate($request->get('per_page', 1)));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  TravelPaymentRequest  $request
     * @return Response
     */
    public function store(TravelPaymentRequest $request)
    {
        $action = new StoreTravelPaymentAction($request);
        return $action->run();
    }

    /**
     * Display the specified resource.
     *
     * @param  TravelPayment  $payment
     * @return PaymentResource
     */
    public function show(TravelPayment $travelPayment): PaymentResource
    {
        return new PaymentResource($travelPayment->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TravelPaymentRequest  $request
     * @param  TravelPayment  $payment
     * @return Response
     */
    public function update(TravelPaymentRequest $request, TravelPayment $travelPayment)
    {
        $action = new UpdateTravelPaymentAction($request, $travelPayment);
        return $action->run();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TravelPayment  $payment
     */
    public function destroy(Request $request, TravelPayment $travelPayment)
    {
        $action = new DeleteAction($request, $travelPayment);
        $action->run();
    }

    /**
     * Approve the payment.
     *
     * @param  TravelPayment $travelPayment
     */
    public function approve(Request $request, TravelPayment $travelPayment)
    {
        $action = new ApprovalAction($request, $travelPayment, PaymentApproval::APPROVED);
        return $action->run();
    }

    /**
     * Disapprove the payment.
     *
     * @param  TravelPayment $travelPayment
     */
    public function disapprove(Request $request, TravelPayment $travelPayment)
    {
        $action = new ApprovalAction($request, $travelPayment, PaymentApproval::DISAPPROVED);
        return $action->run();
    }
}
