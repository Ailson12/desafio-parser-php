<?php

namespace Tests\Unit;

use App\Application\UseCases\Product\Create\CreateProductDTO;
use App\Application\UseCases\Product\Create\CreateProductUseCase;
use App\Domain\Repositories\IProductRepository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    public function test_creates_product()
    {
        $dto = new CreateProductDTO('123', 'A', 'B', 'Mouse');

        $repo = $this->createMock(IProductRepository::class);
        $repo->expects($this->once())->method('create')->willReturnCallback(fn($p) => $p);

        $useCase = new CreateProductUseCase($repo);
        $product = $useCase->execute($dto);

        $this->assertEquals('Mouse', $product->productName);
    }

    public function test_fails_with_empty_name()
    {
        $this->expectException(InvalidArgumentException::class);

        $dto = new CreateProductDTO('123', 'A', 'B', '');
        $mockRepo = $this->createMock(IProductRepository::class);
        $useCase = new CreateProductUseCase($mockRepo);

        $useCase->execute($dto);
    }
}
