<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'location_id',
        'type',
        'title',
        'description',
        'brand',
        'color',
        'event_date',
        'status',
        'contact_info',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReportImage::class);
    }

    public function lostMatches(): HasMany
    {
        return $this->hasMany(ReportMatch::class, 'lost_report_id');
    }

    public function foundMatches(): HasMany
    {
        return $this->hasMany(ReportMatch::class, 'found_report_id');
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(ReportReturn::class);
    }

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }
}