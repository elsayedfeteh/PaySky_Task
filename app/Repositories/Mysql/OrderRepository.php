<?php

namespace App\Repositories\Mysql;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryContract;

class OrderRepository implements OrderRepositoryContract
{
    public function getLatest()
    {
        return Order::latest()->get();
    }

    public function find(int $id)
    {
        return Order::find($id);
    }

    public function store(array $data)
    {
        return Order::create($data);
    }

    public function attachOrderProducts(Order $order, array $orderProducts)
    {
        return $order->products()->attach($orderProducts);
    }

    public function update(Order $order, array $data)
    {
        return $order->update($data);
    }
}
