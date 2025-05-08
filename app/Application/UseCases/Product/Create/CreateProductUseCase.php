<?php

namespace App\Application\UseCases\Product\Create;

use App\Domain\Entities\Product;
use App\Domain\Repositories\IProductRepository;

class CreateProductUseCase
{
    public function __construct(private IProductRepository $repository) {}

    public function execute(CreateProductDTO $dto)
    {
        $product = new Product($dto->code, $dto->brands, $dto->categories, $dto->productName);
        $this->repository->create($product);
        return $product;
    }
}
