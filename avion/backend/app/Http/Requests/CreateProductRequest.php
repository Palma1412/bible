<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product.*.name' => 'required|array|min:1',
            'product.*.price' => 'required|integer|min:1',
            'product.*.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product.*.description' => 'required|string|max:2048',
            'product.*.height' => 'required|integer|min:1',
            'product.*.width' => 'required|integer|min:1',
            'product.*.depth' => 'required|integer|min:1'
        ];
    }
}
