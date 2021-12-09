<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VirusCase extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'place_id',
        'code',
        'age',
        'symptom',
        'gender',
        'date',
        'travel_history',
        'status',
        'recovered_at',
        'death_at',
        'quarantine_at'
    ];

    protected $with = [
        'place'
    ];

    protected $appends = [
        'formatted_date',
        'recovered',
        'death',
        'quarantine'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function getFormattedDateAttribute()
    {
        $date = Carbon::parse($this->date);

        return $date->isoFormat('LL');
    }

    public function getRecoveredAttribute()
    {
        if(!$this->recovered_at) return null;

        $date = Carbon::parse($this->recovered_at);

        return $date->isoFormat('LL');
    }

    public function getDeathAttribute()
    {
        if(!$this->death_at) return null;

        $date = Carbon::parse($this->death_at);

        return $date->isoFormat('LL');
    }

    public function getQuarantineAttribute()
    {
        if(!$this->quarantine_at) return null;

        $date = Carbon::parse($this->quarantine_at);

        return $date->isoFormat('LL');
    }

}
