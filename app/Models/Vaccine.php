<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dosage'
    ];

    public function vaccinations()
    {
    	return $this->hasMany(Vaccination::class);
    }

}
