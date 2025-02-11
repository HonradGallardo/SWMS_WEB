<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminLoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:30'],
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
        ];
    }


    public function messages(): array
    {
        return [
            'password.regex' => 'Incorrect Password',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password cannot exceed 30 characters.',
            'email.max' => 'Email cannot exceed 30 characters.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    // Enforce Strong Password Security Before Authentication
    $this->validatePasswordStrength($this->password);

    if (!Auth::guard('admin')->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('Invalid admin login credentials.'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }

    private function validatePasswordStrength($password)
{
    if (strlen($password) > 30) {
        throw ValidationException::withMessages([
            'password' => 'Password must not exceed 30 characters.',
        ]);
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,30}$/', $password)) {
        throw ValidationException::withMessages([
            'password' => 'Password must contain at least 1 uppercase letter, 1 number, and 1 special character.',
        ]);
    }

    $commonPasswords = ['12345678', 'password', 'qwerty', '123456789', 'abc123', 'admin123', 'letmein'];
    if (in_array(strtolower($password), $commonPasswords)) {
        throw ValidationException::withMessages([
            'password' => 'Please choose a stronger password.',
        ]);
    }
}
}
