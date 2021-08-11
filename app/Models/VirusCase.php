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
        'status'
    ];

    protected $with = [
        'place'
    ];

    protected $appends = [
        'formatted_date'
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

}
