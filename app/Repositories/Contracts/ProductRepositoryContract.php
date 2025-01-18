<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryContract 
{
    public function getLatest();
    public function find(int $id);
    public function getProductsByIds(array $ids);
}
