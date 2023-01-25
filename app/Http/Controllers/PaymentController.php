<?php

namespace App\Http\Controllers;

use App\Actions\Payments\DeleteAction;
use App\Actions\Payments\StorePaymentAction;
use App\Actions\Payments\UpdatePaymentAction;
use App\Http\Requests\Payment\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PaymentResource::collection(Payment::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PaymentRequest  $request
     * @return JsonResponse
     */
    public function store(PaymentRequest $request): JsonResponse
    {
        $action = new StorePaymentAction($request);
        $action->run();

        return response()->json([
            'status' => 'Payment created'
        ]);
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
     * @return JsonResponse
     */
    public function update(PaymentRequest $request, Payment $payment): JsonResponse
    {
        $action = new UpdatePaymentAction($request, $payment);
        $action->run();

        return response()->json([
            'status' => 'Payment updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Payment  $payment
     * @return JsonResponse
     */
    public function destroy(Request $request, Payment $payment): JsonResponse
    {
        $action = new DeleteAction($request, $payment);
        $action->run();

        return response()->json([
            'status' => 'Payment deleted'
        ], 204);
    }
}
