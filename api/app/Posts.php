<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'image'
    ];

    public function comments()
    {
        return $this->morphMany('App\Comments', 'commentable');
    }
}
