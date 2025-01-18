<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface OrderRepositoryContract 
{
    public function getLatest();
    public function find(int $id);
    public function store(array $data);
    public function update(Order $order, array $data);
    public function attachOrderProducts(Order $order, array $orderProducts);
}
