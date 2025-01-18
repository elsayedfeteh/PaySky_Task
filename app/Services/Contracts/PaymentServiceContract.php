<?php

namespace App\Services\Contracts;

interface PaymentServiceContract 
{
    public function changeStatus($status, $order_id);
}
