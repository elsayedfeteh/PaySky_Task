<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order\CreateOrderRequest;
use App\Http\Resources\Api\V1\Order\OrderResource;
use App\Services\Contracts\OrderServiceContract;
use Exception;

class OrderController extends Controller
{
    private OrderServiceContract $orderService;

    public function __construct(OrderServiceContract $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->index();
        return OrderResource::collection($orders->load(['products' => function ($query) { $query->withTrashed(); }]))->additional(['status' => 'success', 'message' => '']);
    }

    public function show($id)
    {
        $order = $this->orderService->show($id);
        if (!$order) return response()->json(['status' => 'fail', 'data' => null, 'message' => 'not found'], 422);
        return OrderResource::make($order->load(['products' => function ($query) { $query->withTrashed(); }]))->additional(['status' => 'success', 'message' => '']);
    }

    public function store(CreateOrderRequest $request)
    {
        try {
            $order = $this->orderService->store(['user_id' => auth('api')->id(), 'products' => $request->products]);
            return response()->json([
                'status'  => 'success',
                'data'    => OrderResource::make($order->load(['products' => function ($query) { $query->withTrashed(); }])),
                'message' => 'Order created successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'data'    => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
