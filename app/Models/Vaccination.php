<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'vaccine_id',
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
        'vaccine_name'
    ];

	public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function getVaccineNameAttribute()
    {
        return $this->vaccine->name;
    }
}
