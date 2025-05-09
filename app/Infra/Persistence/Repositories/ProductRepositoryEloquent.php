<?php

namespace App\Infra\Persistence\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\Repositories\IProductRepository;
use App\Domain\ValueObjects\NutritionInformation;
use App\Infra\Persistence\Models\ProductModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepositoryEloquent implements IProductRepository
{
    public function deleteByCode(string $code): void
    {
        $product = ProductModel::where('code', $code)->first();
        $product->status = ProductStatusEnum::TRASH;
        $product->save();
    }

    public function findByCode(string $code): ?Product
    {
        $product = ProductModel::where('code', $code)->first();
        if (!$product) {
            return null;
        }

        $nutritionInformation = new NutritionInformation(
            $product->nutriments_energy,
            $product->nutriments_fat,
            $product->nutriments_saturated_fat,
            $product->nutriments_sugars,
            $product->nutriments_proteins,
            $product->nutriments_salt,
            $product->ingredients_text
        );

        return new Product(
            $product->code,
            $product->brands,
            $product->categories,
            $product->product_name,
            $product->image_url,
            $product->imported_t,
            $nutritionInformation,
            $product->status,
        );
    }

    public function createAll(array $products): void
    {
        $now = Carbon::now();
        $productsWithTimeStamp = array_map(function ($product) use ($now) {
            $nutritionInformation = $product->getNutritionInformation();
            return [
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
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $products);

        DB::table('products')->insertOrIgnore($productsWithTimeStamp);
    }

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
