<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'body', 'author', 'published'
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
