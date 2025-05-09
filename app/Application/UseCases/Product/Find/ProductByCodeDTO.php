<?php

namespace App\Application\UseCases\Product\Find;

use App\Application\UseCases\Product\BasicProductDTO;
use App\Domain\Entities\Product;

class ProductByCodeDTO extends BasicProductDTO
{
    public string $id;

    public static function mapFromProduct(Product $product)
    {
        $nutritionInformation = $product->getNutritionInformation();
        $productDTO = new self(
            $product->getCode(),
            $product->getBrands(),
            $product->getCategories(),
            $product->getProductName(),
            $product->getImageUrl(),
            $nutritionInformation->getIngredientsText(),
            $nutritionInformation->getEnergy(),
            $nutritionInformation->getFat(),
            $nutritionInformation->getSaturatedFat(),
            $nutritionInformation->getSugars(),
            $nutritionInformation->getProteins(),
            $nutritionInformation->getSalt(),
            $product->getImportedT(),
            $product->getStatus(),
        );
        $productDTO->id = $product->getId();

        return $productDTO;
    }
}
