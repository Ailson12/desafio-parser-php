<?php

namespace Tests\Unit;

use App\Application\UseCases\Product\Find\ListProductsUseCase;
use App\Application\UseCases\Product\Find\ProductByCodeDTO;
use App\Domain\Entities\Product;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\Repositories\IProductRepository;
use App\Domain\ValueObjects\NutritionInformation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\TestCase;

class ListProductsUseCaseTest extends TestCase
{
    public function test_it_returns_paginated_products()
    {
        $mock = $this->createMock(IProductRepository::class);
        $nutritionInformation = new NutritionInformation('energy', 'fat', 'saturatedFat', 'sugars', 'proteins', 'salt', 'ingredientsTexr');
        $product = new Product(
            '0001',
            'Marca',
            'Categoria',
            'Nome do Produto',
            'url.jpg',
            now()->format('Y-m-d H:i:s'),
            $nutritionInformation,
            ProductStatusEnum::PUBLISHED
        );

        $collection = new Collection([$product]);
        $paginator = new LengthAwarePaginator($collection, 1, 10, 1);

        $mock->expects($this->once())
            ->method('paginate')
            ->with(1, 10)
            ->willReturn($paginator);

        $useCase = new ListProductsUseCase($mock);
        $result = $useCase->execute(1, 10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(1, $result->total());
        $this->assertCount(1, $result->items());
        $this->assertInstanceOf(ProductByCodeDTO::class, $result->first()); // Verifica se os itens foram transformados
        $this->assertEquals($product->getCode(), $result->first()->code);
    }
}
