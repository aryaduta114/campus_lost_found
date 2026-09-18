<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Notifications\EmailVerificationOtpNotification;
use App\Services\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Display the OTP verification page.
     */
    public function show(): View
    {
        return view('auth.verify-otp');
    }

    /**
     * Verify the submitted OTP.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = Auth::user();

        $key = 'otp-verify:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'otp' => 'Terlalu banyak percobaan. Silakan coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
            ]);
        }

        $verification = EmailVerification::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->first();

        if (! $verification) {
            RateLimiter::hit($key, 600);

            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak valid.',
            ]);
        }

        if ($verification->expires_at->isPast()) {
            RateLimiter::hit($key, 600);

            throw ValidationException::withMessages([
                'otp' => 'Kode OTP sudah kedaluwarsa.',
            ]);
        }

        $user->update([
            'email_verified_at' => now(),
        ]);

        $verification->delete();

        RateLimiter::clear($key);

        return redirect()->route('dashboard');
    }

    /**
     * Resend a new OTP.
     */
    public function resend(
        Request $request,
        EmailVerificationService $service
    ): RedirectResponse {
        $user = Auth::user();

        $key = 'otp-resend:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'otp' => 'Terlalu banyak permintaan. Silakan coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
            ]);
        }

        RateLimiter::hit($key, 600);

        $otp = $service->generate($user);

        $user->notify(
            new EmailVerificationOtpNotification($otp)
        );

        return back()->with(
            'status',
            'Kode OTP baru telah dikirim ke email Anda.'
        );
    }
}