<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'location_id',
        'location_name',
        'organizer',
        'performer_id',
        'event_date',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function performer()
    {
        return $this->belongsTo(Performer::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
