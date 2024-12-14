<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'author',
        'description',
        'content',
        'source',
        'url',
        'categories',
        'keywords',
        'published_at',
        // 'user_id',
    ];

    protected function casts(): array {
        return [
            'published_at' => 'datetime',
        ];
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function getKeywordsArrayAttribute()
    {
        return explode(',', $this->keywords);
    }

    public function getCategoriesArrayAttribute()
    {
        return explode(',', $this->categories);
    }
}
