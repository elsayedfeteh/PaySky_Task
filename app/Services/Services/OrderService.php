<?php

namespace App\Services\Services;

use App\Const\TaxConst;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\Contracts\OrderServiceContract;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceContract
{
    private OrderRepositoryContract $orderContract;
    private ProductRepositoryContract $productContract;

    public function __construct(OrderRepositoryContract $orderContract, ProductRepositoryContract $productContract)
    {
        $this->orderContract = $orderContract;
        $this->productContract = $productContract;
    }

    public function index()
    {
        return $this->orderContract->getLatest();
    }

    public function show(int $id)
    {
        return $this->orderContract->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $productIds    = collect($data['products'])->pluck('product_id')->toArray();

            $products      = $this->productContract->getProductsByIds($productIds)->keyBy('id');

            $totalAmount   = $this->calculateTotalAmount($data['products'], $products);

            $taxRate       = TaxConst::getTaxRate();
            $totalPrice    = $this->calculateTotalWithTaxRate($totalAmount, $taxRate);

            $order_data    = [
                'user_id'              => $data['user_id'],
                'tax_rate'             => $taxRate,
                'total_products_price' => $totalAmount,
                'total_price'          => $totalPrice,
            ];

            $order         = $this->orderContract->store($order_data);

            $orderProducts = $this->prepareOrderProducts($data['products'], $products);

            $this->orderContract->attachOrderProducts($order, $orderProducts);

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            info($e);
            throw new Exception('Failed to create order.');
        }
    }

    private function calculateTotalAmount($products, $dbProducts): float
    {
        $totalAmount = 0;

        foreach ($products as $product) {
            $dbProduct    = $dbProducts->get($product['product_id']);
            $totalAmount += $product['qty'] * $dbProduct->price;
        }

        return $totalAmount;
    }

    public function calculateTotalWithTaxRate(float $amount): float
    {
        $taxRate = TaxConst::getTaxRate();
        return $amount * (1 + $taxRate);
    }

    private function prepareOrderProducts($products, $dbProducts): array
    {
        $orderProducts = [];

        foreach ($products as $product) {
            $dbProduct = $dbProducts->get($product['product_id']);
            $orderProducts[] = [
                'product_id' => $dbProduct->id,
                'quantity'   => $product['qty'],
                'price'      => $dbProduct->price,
            ];
        }

        return $orderProducts;
    }

    public function changePaymentStatus(int $orderId, string $paymentStatus): array
    {
        DB::beginTransaction();
        try {
            if (!in_array($paymentStatus, ['pending', 'successful', 'failed'])) throw new Exception('Invalid payment status.');

            $order = $this->orderContract->find($orderId);

            if (! $order) throw new Exception('Order Not Found.');

            if (! $this->orderContract->update($order, ['payment_status' => $paymentStatus])) throw new Exception('Not Updated.');

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            info($e);
            return null;
        }
    }
}
