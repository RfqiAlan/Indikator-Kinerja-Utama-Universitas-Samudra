<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $failedAttempts = session('login_failed_attempts', 0);
        $showCaptcha = $failedAttempts >= 3
            && config('services.recaptcha.site_key')
            && config('services.recaptcha.site_key') !== 'your-recaptcha-site-key';

        return view('auth.login', [
            'showCaptcha' => $showCaptcha,
            'recaptchaSiteKey' => config('services.recaptcha.site_key'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Log successful login
        security_log('login', Auth::user()->email, 'Login berhasil');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $email = Auth::user()->email;
        
        // Log logout before destroying session
        security_log('logout', $email, 'User logout');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
