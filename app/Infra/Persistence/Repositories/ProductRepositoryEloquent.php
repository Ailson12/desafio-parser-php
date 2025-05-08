<?php

namespace App\Infra\Persistence\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\IProductRepository;
use App\Infra\Persistence\Models\ProductModel;

class ProductRepositoryEloquent implements IProductRepository
{
    public function create(Product $product): void
    {
        $nutritionInformation = $product->getNutritionInformation();

        ProductModel::create([
            'code' => $product->getCode(),
            'brands' => $product->getBrands(),
            'categories' => $product->getCategories(),
            'product_name' => $product->getProductName(),
            'image_url' => $product->getImageUrl(),
            'ingredients_text' => $nutritionInformation->getIngredientsText(),
            'nutriments_energy' => $nutritionInformation->getEnergy(),
            'nutriments_fat' => $nutritionInformation->getFat(),
            'nutriments_saturated_fat' => $nutritionInformation->getSaturatedFat(),
            'nutriments_sugars' => $nutritionInformation->getSugars(),
            'nutriments_proteins' => $nutritionInformation->getProteins(),
            'nutriments_salt' => $nutritionInformation->getSalt(),
            'imported_t' => $product->getImportedT(),
            'status' => $product->getStatus(),
        ]);
    }
}
