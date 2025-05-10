<?php

namespace App\Infra\Persistence\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\Repositories\IProductRepository;
use App\Infra\Mappers\EloquentProductMapper;
use App\Infra\Persistence\Models\ProductModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepositoryEloquent implements IProductRepository
{
    public function paginate(int $page, int $perPage)
    {
        return ProductModel::where('status', '!=', ProductStatusEnum::TRASH)
            ->paginate($perPage, ['*'], 'page', $page)
            ->through(fn($item) => EloquentProductMapper::toEntity($item));
    }

    public function update(Product $product): void
    {
        $productData = EloquentProductMapper::toModel($product);
        ProductModel::where('code', $product->getCode())
            ->where('status', '!=', ProductStatusEnum::TRASH)
            ->first()
            ->update($productData);
    }

    public function deleteByCode(string $code): void
    {
        $product = ProductModel::where('code', $code)
            ->where('status', '!=', ProductStatusEnum::TRASH)
            ->first();
        $product->status = ProductStatusEnum::TRASH;
        $product->save();
    }

    public function findByCode(string $code): ?Product
    {
        $productModel = ProductModel::where('code', $code)->where('status', '!=', ProductStatusEnum::TRASH)->first();
        if (!$productModel) {
            return null;
        }

        return EloquentProductMapper::toEntity($productModel);
    }

    public function createAll(array $products): void
    {
        $now = Carbon::now();
        $productsWithTimeStamp = array_map(function ($product) use ($now) {
            $productData = EloquentProductMapper::toModel($product)->toArray();

            return array_merge($productData, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $products);

        DB::table('products')->insertOrIgnore($productsWithTimeStamp);
    }

    public function create(Product $product): void
    {
        $productData = EloquentProductMapper::toModel($product);
        ProductModel::create($productData);
    }
}
