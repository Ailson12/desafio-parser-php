<?php

namespace Tests\Unit;

use App\Application\UseCases\Product\Create\CreateProductDTO;
use App\Application\UseCases\Product\Create\CreateProductUseCase;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\Repositories\IProductRepository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    public function makeProductDTO()
    {
        return new CreateProductDTO(
            'ABC123',
            'Brand X',
            'Category A, Category B',
            'Produto Exemplo',
            'https://example.com/image.jpg',
            'Ingredientes: Água, Açúcar, Corante',
            '150kcal',
            '5g',
            '2g',
            '10g',
            '3g',
            '0.5g',
            'imported',
            ProductStatusEnum::PUBLISHED
        );
    }

    public function test_creates_product()
    {
        $dto = $this->makeProductDTO();

        $repo = $this->createMock(IProductRepository::class);
        $repo->expects($this->once())->method('create')->willReturnCallback(fn($p) => $p);

        $useCase = new CreateProductUseCase($repo);
        $product = $useCase->execute($dto);

        $this->assertEquals('Produto Exemplo', $product->getProductName());
    }

    public function test_fails_with_empty_name()
    {
        $this->expectException(InvalidArgumentException::class);

        $dto = $this->makeProductDTO();
        $dto->productName = '';

        $mockRepo = $this->createMock(IProductRepository::class);
        $useCase = new CreateProductUseCase($mockRepo);

        $useCase->execute($dto);
    }
}
