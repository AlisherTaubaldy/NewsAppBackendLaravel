<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function translate($langId)
    {
        return $this->translations->where('lang_id', $langId)->first();
    }
}
