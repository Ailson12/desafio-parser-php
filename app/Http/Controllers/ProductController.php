<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Product\Delete\DeleteProductUseCase;
use Exception;

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
}
