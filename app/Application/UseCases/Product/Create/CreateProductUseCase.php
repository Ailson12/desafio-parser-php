<?php

namespace App\Application\UseCases\Product\Create;

use App\Domain\Repositories\IProductRepository;

class CreateProductUseCase
{
    public function __construct(private IProductRepository $repository) {}

    public function execute(CreateProductDTO $dto)
    {
        $product = $dto->mapperToProduct();
        $this->repository->create($product);
        return $product;
    }
}
