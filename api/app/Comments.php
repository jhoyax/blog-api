<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'body', 'commentable_type', 'commentable_id', 'creator_id', 'parent_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}