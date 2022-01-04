<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
    		'post_id',
        'department_id'
    ];
}
