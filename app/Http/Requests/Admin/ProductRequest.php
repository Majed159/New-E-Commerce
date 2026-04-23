<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|unique:products,name|max:255',
            'product_code' => 'required|unique:products,code|max:255',
            'product_price' => 'required|numeric|gt:0',
            'product_color' => 'required|max:200',
            'family_color' =>'required|regex:/^[\pL\s\-]+$/u|max:200',
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The category field is not exists.',
            'product_name.required' => 'The product name field is required.',
            'product_name.unique' => 'The product name already exists.',
            'product_code.required' => 'The product code field is required.',
            'product_code.unique' => 'The product code already exists.',
            'product_price.required' => 'The product price field is required.',
            'product_price.numeric' => 'The product price must be a number.',
            'product_price.gt' => 'The product price must be a positive number.',
            'product_color.required' => 'The product color field is required.',
            'product_color.regex' => 'The product color must be a valid color.',
            'family_color.required' => 'The family color field is required.',
            'family_color.regex' =>  'Valid Family Color is required',


        ];
    }
}
