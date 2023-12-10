<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["title", "content", "user_id", "category_id"];

    function user(){
        return $this->belongsTo(User::class);
    }

    function category(){
        return $this->belongsTo(Category::class);
    }

    function tags(){
        return $this->belongsToMany(Tag::class);
    }

    function likes(){
        return $this->belongsToMany(User::class);
    }

    function comments(){
        return $this->hasMany(Comment::class);
    }
}
