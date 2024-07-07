<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization logic as needed
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:product_categories,id', // Example of validating existence of category_id in product_categories table
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example of validating image upload
            'sku' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1',
            'flavor' => 'required|string',
            'roast_level' => 'required|string',
            'brewing_method' => 'required|string',
            'pre_ground' => 'required|boolean',
            'decaf' => 'required|boolean',
            // Add more validation rules as needed
        ];
    }
}
