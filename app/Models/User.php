<?php

namespace App\Models;

use App\Models\Claim;
use App\Models\EmailVerification;
use App\Models\Report;
use App\Models\ReportReturn;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'nim_nidn', 'email', 'password', 'role', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the reports created by the user.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get the claims submitted by the user.
     */
    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    /**
     * Get the returns made by the user.
     */
    public function returnsMade(): HasMany
    {
        return $this->hasMany(ReportReturn::class, 'returned_by');
    }

    /**
     * Get the returns received by the user.
     */
    public function returnsReceived(): HasMany
    {
        return $this->hasMany(ReportReturn::class, 'received_by');
    }

    /**
     * Get the email verification record.
     */
    public function emailVerification(): HasOne
    {
        return $this->hasOne(EmailVerification::class);
    }
}