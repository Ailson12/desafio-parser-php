<?php

namespace App\Application\UseCases\Product\Update;

use App\Application\UseCases\Product\BasicProductDTO;
use App\Application\UseCases\Product\Find\ProductByCodeDTO;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\NutritionInformation;

class UpdateProductDTO extends BasicProductDTO
{
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

    public function mapperToProduct(string $importedT): Product
    {
        $nutritionInformation = $this->mapperNutritionInformation();
        return new Product(
            $this->code,
            $this->brands,
            $this->categories,
            $this->productName,
            $this->image_url,
            $importedT,
            $nutritionInformation,
            $this->status
        );
    }
}
