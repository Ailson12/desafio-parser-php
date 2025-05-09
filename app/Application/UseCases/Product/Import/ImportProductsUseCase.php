<?php

namespace App\Application\UseCases\Product\Import;

use App\Application\UseCases\Product\Create\CreateProductDTO;
use App\Domain\Repositories\IProductRepository;

class ImportProductsUseCase
{
    public function __construct(private IProductRepository $repository) {}

    /**
     * @param array<int, CreateProductDTO> $productsDTO
     */
    public function execute(array $productsDTO)
    {
        $products = collect($productsDTO)
            ->map(fn($product) => $product->mapperToProduct())
            ->toArray();

        $this->repository->createAll($products);
    }
}
