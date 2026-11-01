<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'event_id',
        'activity_name',
        'description',
        'start_time',
        'end_time',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}