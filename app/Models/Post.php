<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;

class Post extends Model
{
    protected $fillable =[
        'title',
        'slug',
        'category_id',
        'color',
        'image',
        'body',
        'published',
        'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}
