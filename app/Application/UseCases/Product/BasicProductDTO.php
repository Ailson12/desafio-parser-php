<?php

namespace App\Application\UseCases\Product;

use App\Domain\Enum\ProductStatusEnum;

class BasicProductDTO
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
}
