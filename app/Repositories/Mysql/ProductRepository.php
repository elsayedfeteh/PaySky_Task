<?php

namespace App\Repositories\Mysql;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;

class ProductRepository implements ProductRepositoryContract
{
    public function getLatest()
    {
        return Product::latest()->get();
    }

    public function find(int $id)
    {
        return Product::find($id);
    }

    public function getProductsByIds(array $ids)
    {
        return Product::whereIn('id', $ids)->get();
    }
}
