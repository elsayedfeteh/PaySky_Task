<?php

namespace App\Http\Resources\Api\V1\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'tax_rate'             => $this->tax_rate,
            'total_products_price' => $this->total_products_price,
            'total_price'          => $this->total_price,
            'status'               => $this->status,
            'payment_status'       => $this->payment_status,
            'products'             => OrderProductResource::collection($this->products),
            'created_at'           => $this->created_at->format('Y-m-d')
        ];
    }
}
