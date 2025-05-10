<?php

namespace App\Infra\Mappers;

use App\Domain\Entities\Product;
use App\Domain\ValueObjects\NutritionInformation;
use App\Infra\Persistence\Models\ProductModel;
use Carbon\Carbon;

class EloquentProductMapper
{
    public static function toModel(Product $product): ProductModel
    {
        $nutritionInformation = $product->getNutritionInformation();

        $model = new ProductModel();
        $model->code = $product->getCode();
        $model->brands = $product->getBrands();
        $model->categories = $product->getCategories();
        $model->product_name = $product->getProductName();
        $model->image_url = $product->getImageUrl();
        $model->ingredients_text = $nutritionInformation->getIngredientsText();
        $model->nutriments_energy = $nutritionInformation->getEnergy();
        $model->nutriments_fat = $nutritionInformation->getFat();
        $model->nutriments_saturated_fat = $nutritionInformation->getSaturatedFat();
        $model->nutriments_sugars = $nutritionInformation->getSugars();
        $model->nutriments_proteins = $nutritionInformation->getProteins();
        $model->nutriments_salt = $nutritionInformation->getSalt();
        $model->imported_t = $product->getImportedT();
        $model->status = $product->getStatus();

        return $model;
    }

    public static function toEntity(ProductModel $model): Product
    {
        return new Product(
            code: $model->code,
            brands: $model->brands,
            categories: $model->categories,
            productName: $model->product_name,
            imageUrl: $model->image_url,
            nutritionInformation: new NutritionInformation(
                ingredientsText: $model->ingredients_text,
                energy: $model->nutriments_energy,
                fat: $model->nutriments_fat,
                saturatedFat: $model->nutriments_saturated_fat,
                sugars: $model->nutriments_sugars,
                proteins: $model->nutriments_proteins,
                salt: $model->nutriments_salt,
            ),
            importedT: $model->imported_t ? Carbon::parse($model->imported_t) : null,
            status: $model->status,
            id: $model->id
        );
    }
}
