<?php

namespace Tests\Unit;

use App\Application\UseCases\Product\Delete\DeleteProductUseCase;
use App\Domain\Entities\Product;
use App\Domain\Repositories\IProductRepository;
use PHPUnit\Framework\TestCase;

class DeleteProductUseCaseTest extends TestCase
{
    public function test_should_delete_product_successfully()
    {
        $code = '12345';
        $mockProduct = $this->createMock(Product::class);

        $repo = $this->createMock(IProductRepository::class);
        $repo->expects($this->once())
            ->method('findByCode')
            ->with($code)
            ->willReturn($mockProduct);

        $repo->expects($this->once())
            ->method('deleteByCode')
            ->with($code);

        $useCase = new DeleteProductUseCase($repo);
        $useCase->execute($code);
    }

    public function test_should_throw_exception_if_product_not_found()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Product with code 12345 not found.');

        $repo = $this->createMock(IProductRepository::class);
        $repo->method('findByCode')->willReturn(null);

        $useCase = new DeleteProductUseCase($repo);
        $useCase->execute('12345');
    }
}
