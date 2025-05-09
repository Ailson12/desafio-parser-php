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
    public function update(Product $product): void
    {
        $productData = $this->mapperProductToModel($product);
        ProductModel::where('code', $product->getCode())
            ->first()
            ->update($productData);
    }

    public function deleteByCode(string $code): void
    {
        $product = ProductModel::where('code', $code)->first();
        $product->status = ProductStatusEnum::TRASH;
        $product->save();
    }

    public function findByCode(string $code): ?Product
    {
        $productModel = ProductModel::where('code', $code)->first();
        if (!$productModel) {
            return null;
        }

        $nutritionInformation = new NutritionInformation(
            $productModel->nutriments_energy,
            $productModel->nutriments_fat,
            $productModel->nutriments_saturated_fat,
            $productModel->nutriments_sugars,
            $productModel->nutriments_proteins,
            $productModel->nutriments_salt,
            $productModel->ingredients_text
        );

        return new Product(
            $productModel->code,
            $productModel->brands,
            $productModel->categories,
            $productModel->product_name,
            $productModel->image_url,
            $productModel->imported_t,
            $nutritionInformation,
            $productModel->status,
            $productModel->id
        );
    }

    public function createAll(array $products): void
    {
        $now = Carbon::now();
        $productsWithTimeStamp = array_map(function ($product) use ($now) {
            $productData = $this->mapperProductToModel($product);

            return array_merge($productData, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $products);

        DB::table('products')->insertOrIgnore($productsWithTimeStamp);
    }

    public function create(Product $product): void
    {
        $productData = $this->mapperProductToModel($product);
        ProductModel::create($productData);
    }

    private function mapperProductToModel(Product $product)
    {
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
        ];
    }
}
