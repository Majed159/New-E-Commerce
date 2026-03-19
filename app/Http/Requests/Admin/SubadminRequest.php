<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubadminRequest extends FormRequest
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
        $passwordRule = $this->input('id') ? 'nullable|string|min:6' : 'required|string|min:6';

        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => $passwordRule,
            'image' => 'image',
            'phone' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is Required',
            'email.required' => 'Email is Required',
            'phone.required' => 'Phone is Required',
            'password.required' => 'Password is Required',
            'password.min' => 'Password is too short',
            'image.image' =>  'Please upload a valid image',
            'phone.numeric' =>  'Please enter a valid phone number',
            'email.email' => 'Please enter a valid email',
        ];
    }
    public  function  withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('id') == ""){
                $subadminCount = Admin::where('email', $this->input('email'))->count();
                if ($subadminCount > 0){
                    $validator->errors()->add('email', 'Email Already Exists');
                }
            }
        });
    }
    protected  function failedValidation(Validator $validator)
    {
        throw  new  HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
