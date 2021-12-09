<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'name',
        'age',
        'birth_date',
        'gender',
        'phone',
        'classification'
    ];

    protected $with = [
        'place'
    ];

    protected $appends = [ 
        'date'
    ];

	public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function getDateAttribute()
    {
        $date = Carbon::parse($this->update_at);

        return $date->isoFormat('LL');
    }
}
