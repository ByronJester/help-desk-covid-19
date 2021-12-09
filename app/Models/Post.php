<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'content',
        'allow_comment'
    ];

    protected $with = [
    	'images', 'user'
    ];

    protected $appends = [
        'posted_date'
    ];

    public function images()
    {
    	return $this->hasMany(PostImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPostedDateAttribute()
    {
        $date = Carbon::parse($this->created_at);

        return $date->isoFormat('LL');
    }
}
