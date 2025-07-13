<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostGallery extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Allow mass assignment for these columns
    protected $fillable = [
        'post_id',
        'post_gallery', // the column for the gallery image path
    ];
}
