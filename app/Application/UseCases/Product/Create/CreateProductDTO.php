<?php

namespace App\Application\UseCases\Product\Create;

use App\Domain\Entities\Product;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\ValueObjects\NutritionInformation;

class CreateProductDTO
{
    public function __construct(
        public string $code,
        public string $brands,
        public string $categories,
        public string $productName,
        public string $image_url,
        public string $ingredients_text,
        public string $nutriments_energy,
        public string $nutriments_fat,
        public string $nutriments_saturated_fat,
        public string $nutriments_sugars,
        public string $nutriments_proteins,
        public string $nutriments_salt,
        public string $imported_t,
        public ProductStatusEnum $status,
    ) {}

    private function mapperNutritionInformation()
    {
        return new NutritionInformation(
            $this->nutriments_energy,
            $this->nutriments_fat,
            $this->nutriments_saturated_fat,
            $this->nutriments_sugars,
            $this->nutriments_proteins,
            $this->nutriments_salt,
            $this->ingredients_text,
        );
    }

    public function mapperToProduct()
    {
        $nutritionInformation = $this->mapperNutritionInformation();
        return new Product(
            $this->code,
            $this->brands,
            $this->categories,
            $this->productName,
            $this->image_url,
            $this->imported_t,
            $nutritionInformation,
            $this->status
        );
    }
}
