<?php

namespace App\Services\Services;

use App\Services\Contracts\OrderServiceContract;
use App\Services\Contracts\PaymentServiceContract;

class PaymentService implements PaymentServiceContract
{
    private OrderServiceContract $orderService;

    public function __construct(OrderServiceContract $orderService)
    {
        $this->orderService = $orderService;
    }

    public function changeStatus($status, $order_id)
    {
        return $this->orderService->changePaymentStatus($order_id, $status);
    }
}
