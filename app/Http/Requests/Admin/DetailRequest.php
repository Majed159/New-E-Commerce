<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'phone' => 'required|numeric|digits_between:10,11',
            'image ' =>'image',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
             'name.regex' => 'Valid Name is required',
            'name.max' => 'Name should be less than 255 characters',
            'phone.digits_between' => 'Valid Phone number is required',
            'phone.required' => 'Phone number is required',
            'phone.numeric' => 'Phone number must be a number',
            'image.image' => 'Valid image is required',

        ];
    }
}
