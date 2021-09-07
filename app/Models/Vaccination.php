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
        'start_date',
        'completed_date'
    ];

    protected $with = [
        'place'
    ];

		public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
