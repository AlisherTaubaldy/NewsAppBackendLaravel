<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['lang_id', 'title', 'description', 'image_url', 'link', 'seo_title', 'seo_description', 'seo_keywords'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }
}
