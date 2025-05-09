<?php

namespace Tests\Unit;

use App\Application\UseCases\Product\Find\GetProductByCodeUseCase;
use App\Application\UseCases\Product\Find\ProductByCodeDTO;
use App\Application\UseCases\Product\Update\UpdateProductDTO;
use App\Application\UseCases\Product\Update\UpdateProductUseCase;
use App\Domain\Enum\ProductStatusEnum;
use App\Domain\Repositories\IProductRepository;
use PHPUnit\Framework\TestCase;

class UpdateProductUseCaseTest extends TestCase
{
    public function test_should_call_repository_with_correct_data()
    {
        $code = '1234567890123';
        $repository = $this->createMock(IProductRepository::class);
        $getByCodeUseCase = $this->createMock(GetProductByCodeUseCase::class);

        $dto = new UpdateProductDTO(
            $code,
            'Marca Atualizada',
            'Categoria Atualizada',
            'Produto Atualizado',
            'https://imagem.com/novo.jpg',
            'Ingredientes atualizados',
            '100.5',
            '10.1',
            '5.2',
            '12.3',
            '7.8',
            '1.2',
            '',
            ProductStatusEnum::PUBLISHED,
        );

        $product = $dto->mapperToProduct(now()->format('Y-m-d H:i:s'));

        $getByCodeUseCase->expects($this->once())
            ->method('execute')
            ->with($code)
            ->willReturn(ProductByCodeDTO::mapFromProduct($product));

        $repository->expects($this->once())
            ->method('update')
            ->with($product);

        $useCase = new UpdateProductUseCase($repository,  $getByCodeUseCase);
        $useCase->execute($code, $dto);
    }
}
