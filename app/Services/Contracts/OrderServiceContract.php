<?php

namespace App\Services\Contracts;

interface OrderServiceContract 
{
    public function index();
    public function show(int $id);
    public function store($products);
    public function changePaymentStatus(int $orderId, string $paymentStatus);
}
