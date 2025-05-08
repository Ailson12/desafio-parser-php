<?php

namespace App\Application\UseCases\Product\Create;

use App\Domain\Entities\Product;
use App\Domain\Repositories\IProductRepository;
use App\Domain\ValueObjects\NutritionInformation;

class CreateProductUseCase
{
    public function __construct(private IProductRepository $repository) {}

    public function execute(CreateProductDTO $dto)
    {
        $product = $this->mapperProduct($dto);
        $this->repository->create($product);
        return $product;
    }

    private function mapperNutritionInformation(CreateProductDTO $dto)
    {
        return new NutritionInformation(
            $dto->nutriments_energy,
            $dto->nutriments_fat,
            $dto->nutriments_saturated_fat,
            $dto->nutriments_sugars,
            $dto->nutriments_proteins,
            $dto->nutriments_salt,
            $dto->ingredients_text,
        );
    }

    private function mapperProduct(CreateProductDTO $dto)
    {
        $nutritionInformation = $this->mapperNutritionInformation($dto);
        return new Product(
            $dto->code,
            $dto->brands,
            $dto->categories,
            $dto->productName,
            $dto->image_url,
            $dto->imported_t,
            $nutritionInformation,
            $dto->status
        );
    }
}
