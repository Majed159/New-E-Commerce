<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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

            'current_pwd' => ['required','string','min:6'],
            'new_pwd' => ['required','string','different:current_pwd','min:6'],
            'confirm_pwd' => ['required','string','same:new_pwd'],
        ];
    }
    public function messages(): array
    {
            return [
                'current_pwd.required' => 'Current Password is required',
                'current_pwd.min' => 'Current Password must be at least 6 characters',
                'new_pwd.required' => 'New Password is required',
                'new_pwd.min' => 'New Password must be at least 6 characters',
                'new_pwd.different' => 'New Password must be different from old password',
                'confirm_pwd.required' => 'Confirm Password is required',
                'confirm_pwd.same' => 'Confirm Password must be same as new password',

            ];
    }
}
