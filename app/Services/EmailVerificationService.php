<?php

namespace App\Services;

use App\Models\EmailVerification;
use App\Models\User;

class EmailVerificationService
{
    /**
     * Generate and store a new OTP for the user.
     */
    public function generate(User $user): string
    {
        $otp = (string) random_int(100000, 999999);

        EmailVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]
        );

        return $otp;
    }
}