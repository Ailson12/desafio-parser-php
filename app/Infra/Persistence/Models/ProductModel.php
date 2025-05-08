<?php

namespace App\Infra\Persistence\Models;

use App\Domain\Enum\ProductStatusEnum;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'code',
        'product_name',
        'brands',
        'categories',
        'image_url',
        'ingredients_text',
        'nutriments_energy',
        'nutriments_fat',
        'nutriments_saturated_fat',
        'nutriments_sugars',
        'nutriments_proteins',
        'nutriments_salt',
        'imported_t',
        'status',
    ];

    protected $casts = [
        'status' => ProductStatusEnum::class,
    ];
}
