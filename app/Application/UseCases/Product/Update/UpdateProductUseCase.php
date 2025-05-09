<?php

namespace App\Application\UseCases\Product\Update;

use App\Application\UseCases\Product\Find\GetProductByCodeUseCase;
use App\Domain\Repositories\IProductRepository;
use Exception;

class UpdateProductUseCase
{
    public function __construct(
        private IProductRepository $productRepository,
        private GetProductByCodeUseCase $getProductByCodeUseCase
    ) {}

    public function execute(string $code, UpdateProductDTO $dto): void
    {
        $product = $this->getProductByCodeUseCase->execute($code);
        if (!$product) {
            throw new Exception("Product with code {$code} not found.");
        }

        $productUpdate = $dto->mapperToProduct($product);
        $this->productRepository->update($productUpdate);
    }
}
