<?php
namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AdminRegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:30', 'unique:admins,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:30',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,30}$/',
                function ($attribute, $value, $fail) {
                    $commonPasswords = ['12345678', 'password', 'qwerty', '123456789', 'abc123', 'admin123', 'letmein'];
                    if (in_array(strtolower($value), $commonPasswords)) {
                        $fail('Please choose a stronger password.');
                    }
                },
            ],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'Name must not exceed 50 characters.',
            'email.required' => 'The email field is required.',
            'email.max' => 'Email cannot exceed 30 characters.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password cannot exceed 30 characters.',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 number, and 1 special character.',
            'password_confirmation.required' => 'Please confirm your password.',
            'password_confirmation.same' => 'Password confirmation must match the password.',
        ];
    }
}
