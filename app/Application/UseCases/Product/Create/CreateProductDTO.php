<?php

namespace App\Application\UseCases\Product\Create;

class CreateProductDTO
{
	public function __construct(
		public string $code,
		public string $brands,
		public string $categories,
		public string $productName,
	) {}
}
