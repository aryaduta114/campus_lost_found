<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\EmailVerificationOtpNotification;
use App\Services\EmailVerificationService;
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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(
        LoginRequest $request,
        EmailVerificationService $verificationService
    ): RedirectResponse {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if (! $user->email_verified_at) {
            $otp = $verificationService->generate($user);

            $user->notify(
                new EmailVerificationOtpNotification($otp)
            );

            return redirect()->route('otp.show');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}