<?php

namespace App\Infra\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $textRequired = 'required|string';

        return [
            'brands' => $textRequired,
            'categories' => $textRequired,
            'productName' => $textRequired,
            'image_url' => 'nullable|string',
            'ingredients_text' => 'nullable|string',
            'nutriments_energy' => 'required',
            'nutriments_fat' => 'required',
            'nutriments_saturated_fat' => 'required',
            'nutriments_sugars' => 'required',
            'nutriments_proteins' => 'required',
            'nutriments_salt' => 'required',
            'status' => 'required|string|in:draft,published',
        ];
    }
}
