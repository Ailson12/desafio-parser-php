<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

interface IProductRepository
{
    public function create(Product $product): void;
}
