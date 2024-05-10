<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['lang', 'title', 'description', 'image_url', 'link', 'seo_title', 'seo_description', 'seo_keywords'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
