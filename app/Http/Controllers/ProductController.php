<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Product\Delete\DeleteProductUseCase;
use App\Application\UseCases\Product\Find\GetProductByCodeUseCase;
use App\Application\UseCases\Product\Find\ListProductsUseCase;
use App\Application\UseCases\Product\Update\UpdateProductDTO;
use App\Application\UseCases\Product\Update\UpdateProductUseCase;
use App\Domain\Enum\ProductStatusEnum;
use App\Infra\Requests\UpdateProductRequest;
use Exception;
use Throwable;

class ProductController extends Controller
{
    public function index(ListProductsUseCase $useCase)
    {
        try {
            $page = (int) request()->query('page', 1);
            $perPage = (int) request()->query('per_page', 10);

            $products = $useCase->execute($page, $perPage);
            return response()->json($products);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function destroy(string $code, DeleteProductUseCase $useCase)
    {
        try {
            $useCase->execute($code);
            return response()->json(['message' => 'Product successfully deleted.'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function update(string $code, UpdateProductRequest $request, UpdateProductUseCase $useCase)
    {
        try {
            $validated = $request->validated();
            $dto = new UpdateProductDTO(
                ...array_merge(
                    $validated,
                    [
                        'code' => $code,
                        'imported_t' => '',
                        'status' => ProductStatusEnum::from($validated['status']),
                    ]
                )
            );
            $useCase->execute($code, $dto);
            return response()->json(['message' => 'Product successfully updated.']);
        } catch (Throwable $throwable) {
            return response()->json(['error' => $throwable->getMessage()], 404);
        }
    }

    public function show(string $code, GetProductByCodeUseCase $useCase)
    {
        try {
            $product = $useCase->execute($code);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json($product);
        } catch (Throwable $throwable) {
            return response()->json(['error' => $throwable->getMessage()], 404);
        }
    }
}
