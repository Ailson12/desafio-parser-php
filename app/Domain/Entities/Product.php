<?php

namespace App\Domain\Entities;

class Product
{
    public function __construct(
        public string $code,
        public string $brands,
        public string $categories,
        public string $productName,
    ) {}
}
