<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['title', 'slug', 'image', 'body', 'excerpt', 'meta_description', 'user_id', 'status'];


    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'posts_categories')->withTimestamps();
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags')->withTimestamps();
    }
}
