<?php

namespace Tests\Unit;

use App\Application\UseCases\Product\Find\GetProductByCodeUseCase;
use App\Application\UseCases\Product\Find\ProductByCodeDTO;
use App\Domain\Entities\Product;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\Repositories\IProductRepository;
use App\Domain\ValueObjects\NutritionInformation;
use PHPUnit\Framework\TestCase;

class GetProductByCodeUseCaseTest extends TestCase
{
    public function makeProduct()
    {
        $nutritionInformation = new NutritionInformation(
            'energy',
            'fat',
            'saturatedFat',
            'sugars',
            'proteins',
            'salt',
            'ingredientsTexr'
        );

        return new Product(
            '123456',
            'Marca Teste',
            'Categoria Teste',
            'Produto Teste',
            'https://imagem.com/produto.jpg',
            now(),
            $nutritionInformation,
            ProductStatusEnum::PUBLISHED,
            '1921'
        );
    }

    public function test_should_return_product_when_code_exists()
    {
        $mockRepository = $this->createMock(IProductRepository::class);
        $product = $this->makeProduct();

        $mockRepository->expects($this->once())
            ->method('findByCode')
            ->with('123456')
            ->willReturn($product);

        $useCase = new GetProductByCodeUseCase($mockRepository);

        $result = $useCase->execute('123456');

        $this->assertInstanceOf(ProductByCodeDTO::class, $result);
        $this->assertEquals('Produto Teste', $result->productName);
    }

    public function test_should_return_null_when_code_does_not_exist()
    {
        $mockRepository = $this->createMock(IProductRepository::class);

        $mockRepository->expects($this->once())
            ->method('findByCode')
            ->with('0000000000000')
            ->willReturn(null);

        $useCase = new GetProductByCodeUseCase($mockRepository);

        $result = $useCase->execute('0000000000000');

        $this->assertNull($result);
    }
}
