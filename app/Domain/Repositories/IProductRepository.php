<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

interface IProductRepository
{
    public function update(Product $product): void;

    public function deleteByCode(string $code): void;

    public function findByCode(string $code): ?Product;

    public function create(Product $product): void;

    /**
     * @param array<int, Product> $products
     */
    public function createAll(array $products): void;
}
