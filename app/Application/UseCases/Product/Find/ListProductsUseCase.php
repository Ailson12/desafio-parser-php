<?php

namespace   App\Application\UseCases\Product\Find;

use App\Domain\Repositories\IProductRepository;

class ListProductsUseCase
{
    public function __construct(private IProductRepository $repository) {}

    public function execute(int $page = 1, int $perPage = 10)
    {
        return $this->repository
            ->paginate($page, $perPage)
            ->through(fn($item) => ProductByCodeDTO::mapFromProduct($item));
    }
}
