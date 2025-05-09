<?php

namespace App\Application\UseCases\Product\Delete;

use App\Domain\Repositories\IProductRepository;
use Exception;

class DeleteProductUseCase
{
    public function __construct(private IProductRepository $repository) {}

    public function execute(string $code)
    {
        $product = $this->repository->findByCode($code);

        if (!$product) {
            throw new Exception("Product with code {$code} not found.");
        }

        $this->repository->deleteByCode($code);
    }
}
