<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
        $rules = [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];

        // Require CAPTCHA after 3 failed login attempts
        if ($this->shouldRequireCaptcha()) {
            $rules['g-recaptcha-response'] = ['required'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Silakan selesaikan verifikasi CAPTCHA.',
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

        // Verify reCAPTCHA if required
        if ($this->shouldRequireCaptcha()) {
            $this->verifyCaptcha();
        }

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Increment failed login counter in session
            $failedAttempts = session('login_failed_attempts', 0) + 1;
            session(['login_failed_attempts' => $failedAttempts]);

            // Log failed login attempt
            security_log('login_failed', $this->string('email'), 'Login gagal - password salah');

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Reset failed attempts on successful login
        session()->forget('login_failed_attempts');

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

        // Log lockout event
        security_log('lockout', $this->string('email'), "Rate limited - terlalu banyak percobaan login. Diblokir selama {$seconds} detik.");

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

    /**
     * Determine if CAPTCHA should be required (after 3 failed attempts).
     */
    public function shouldRequireCaptcha(): bool
    {
        return session('login_failed_attempts', 0) >= 3
            && config('services.recaptcha.site_key')
            && config('services.recaptcha.site_key') !== 'your-recaptcha-site-key';
    }

    /**
     * Verify the reCAPTCHA response with Google.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function verifyCaptcha(): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $this->input('g-recaptcha-response'),
            'remoteip' => $this->ip(),
        ]);

        if (! $response->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Verifikasi CAPTCHA gagal. Silakan coba lagi.',
            ]);
        }
    }
}
