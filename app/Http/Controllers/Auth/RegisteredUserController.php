<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailVerificationOtpNotification;
use App\Services\EmailVerificationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(
        Request $request,
        EmailVerificationService $verificationService
    ): RedirectResponse {
        $request->validate([
            'nim_nidn' => ['required', 'string', 'max:50', 'unique:' . User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nim_nidn' => $request->nim_nidn,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'USER',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $otp = $verificationService->generate($user);

        $user->notify(
            new EmailVerificationOtpNotification($otp)
        );

        return redirect()->route('otp.show');
    }
}