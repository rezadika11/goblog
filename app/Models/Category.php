<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['title', 'slug'];

    public function post()
    {
        return $this->belongsToMany(Post::class, 'posts_categories');
    }
}
