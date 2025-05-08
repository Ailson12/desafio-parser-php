<?php

namespace App\Domain\Entities;

use InvalidArgumentException;

class Product
{
    public function __construct(
        public string $code,
        public string $brands,
        public string $categories,
        public string $productName,
    ) {
        if (!strlen($productName)) {
            throw new InvalidArgumentException('Product name cannot be empty.');
        }
    }
}
