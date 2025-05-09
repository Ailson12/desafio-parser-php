<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Product\Delete\DeleteProductUseCase;
use App\Application\UseCases\Product\Find\GetProductByCodeUseCase;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function destroy(string $code, DeleteProductUseCase $useCase)
    {
        try {
            $useCase->execute($code);
            return response()->json(['message' => 'Product successfully deleted.'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function show(string $code, GetProductByCodeUseCase $useCase)
    {
        $product = $useCase->execute($code);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
