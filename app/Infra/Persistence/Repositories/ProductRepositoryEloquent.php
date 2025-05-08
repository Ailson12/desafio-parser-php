<?php

namespace App\Infra\Persistence\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\IProductRepository;
use App\Infra\Persistence\Models\ProductModel;

class ProductRepositoryEloquent implements IProductRepository
{
    public function create(Product $product): void
    {
        ProductModel::create([
            'code' => $product->code,
            'brands' => $product->brands,
            'categories' => $product->categories,
            'product_name' => $product->productName,
        ]);
    }
}
