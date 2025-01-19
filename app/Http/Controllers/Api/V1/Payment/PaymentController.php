<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Payment\ChangeStatusRequest;
use App\Services\Contracts\PaymentServiceContract;

class PaymentController extends Controller
{
    private PaymentServiceContract $paymentService;

    public function __construct(PaymentServiceContract $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function changePaymentStatus(ChangeStatusRequest $request, int $orderId)
    {
        $order = $this->paymentService->changeStatus($request->payment_status, $orderId);
        if (! $order) return response()->json(['status' => 'success', 'data' => null, 'message' => 'Updated Successfully.']);
        return response()->json(['status' => 'fail', 'data' => null, 'message' => 'Not Updated.'], 400);
    }
}
