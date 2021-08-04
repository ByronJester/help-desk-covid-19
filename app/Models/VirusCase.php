<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
