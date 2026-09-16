<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoEmoji implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/[^\x00-\x7F]/', $value)) {
            $fail('Field :attribute tidak boleh mengandung emoji atau karakter khusus.');
        }
    }
}
