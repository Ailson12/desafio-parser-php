<?php

namespace App\Application\UseCases\Product\Find;

use App\Domain\Repositories\IProductRepository;

class GetProductByCodeUseCase
{
    public function __construct(
        private IProductRepository $productRepository
    ) {}

    public function execute(string $code): ?ProductByCodeDTO
    {
        $product = $this->productRepository->findByCode($code);
        if (!$product) {
            return null;
        }
        return ProductByCodeDTO::mapFromProduct($product);
    }
}
