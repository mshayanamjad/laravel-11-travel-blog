<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavPost extends Model
{
    public $fillable = ['user_id', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
