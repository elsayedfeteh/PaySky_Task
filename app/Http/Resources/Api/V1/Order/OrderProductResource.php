<?php

namespace App\Http\Resources\Api\V1\Order;

use App\Http\Resources\Api\V1\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'quantity' => $this->pivot->quantity,
            'price'    => $this->pivot->price,
            'product'  => ProductResource::make($this)
        ];
    }
}
