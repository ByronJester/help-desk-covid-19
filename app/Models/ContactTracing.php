<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTracing extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'virus_case_id',
        'name',
        'age',
        'birth_date',
        'phone',
        'gender',
        'status'
    ];
}
