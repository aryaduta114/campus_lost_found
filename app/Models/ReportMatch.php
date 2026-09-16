<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'lost_report_id',
        'found_report_id',
        'score',
        'status',
    ];

    public function lostReport(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'lost_report_id');
    }

    public function foundReport(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'found_report_id');
    }
}