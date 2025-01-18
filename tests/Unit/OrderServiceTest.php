<?php

namespace Tests\Unit;

use App\Const\TaxConst;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Mysql\OrderRepository;
use App\Repositories\Mysql\ProductRepository;
use App\Services\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        $orderRepository    = new OrderRepository();
        $productRepository  = new ProductRepository();

        $this->orderService = new OrderService($orderRepository, $productRepository);
    }

    public function test_create_order_with_valid_data(): void
    {
        $user      = User::factory()->create();
        $product   = Product::factory()->create(['name' => 'Product 1', 'price' => 100.00]);
        $orderData = [
            'user_id'  => $user->id,
            'products' => [
                ['product_id' => $product->id, 'qty' => 2],
            ],
        ];

        $order = $this->orderService->store($orderData);

        $this->assertDatabaseHas('orders', [
            'id'                   => $order->id,
            'user_id'              => $user->id,
            'tax_rate'             => TaxConst::getTaxRate(),
            'total_products_price' => 200.00,
            'total_price'          => 220.00,
            'status'               => 'pending',
            'payment_status'       => 'pending',
        ]);
    }
}
