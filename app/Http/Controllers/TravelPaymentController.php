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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TravelPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PaymentResource::collection(TravelPayment::with('user')->get());
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
        $action->run();

        return response()->json([
            'message' => 'Travel payment created'
        ]);
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
        $action->run();

        return response()->json([
            'message' => 'Travel payment updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TravelPayment  $payment
     * @return JsonResponse
     */
    public function destroy(Request $request, TravelPayment $travelPayment): JsonResponse
    {
        $action = new DeleteAction($request, $travelPayment);
        $action->run();

        return response()->json([
            'message' => 'Travel payment deleted'
        ], 204);
    }

    /**
     * Approve the payment.
     *
     * @param  TravelPayment $travelPayment
     * @return JsonResponse
     */
    public function approve(Request $request, TravelPayment $travelPayment): JsonResponse
    {
        $action = new ApprovalAction($request, $travelPayment, PaymentApproval::APPROVED);
        $action->run();

        return response()->json([
            'message' => 'Payment approved'
        ]);
    }

    /**
     * Disapprove the payment.
     *
     * @param  TravelPayment $travelPayment
     * @return JsonResponse
     */
    public function disapprove(Request $request, TravelPayment $travelPayment): JsonResponse
    {
        $action = new ApprovalAction($request, $travelPayment, PaymentApproval::DISAPPROVED);
        $action->run();

        return response()->json([
            'message' => 'Payment disapproved'
        ]);
    }
}
