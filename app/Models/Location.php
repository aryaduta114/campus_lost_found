<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
    ];

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}