<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportReturn extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'report_id',
        'claim_id',
        'returned_by',
        'received_by',
        'returned_at',
        'notes',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }

    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    protected function casts(): array
    {
        return [
            'returned_at' => 'datetime',
        ];
    }
}