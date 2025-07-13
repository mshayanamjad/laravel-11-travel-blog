<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Define the relationship with User (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Post.php
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Get views
    public function getViews()
    {
        return $this->views;
    }

    // Define the relationship to the PostGallery model
    public function gallery()
    {
        return $this->hasMany(PostGallery::class, 'post_id');
    }

}
