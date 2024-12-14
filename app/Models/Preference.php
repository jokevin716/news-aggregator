<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'categories',
        'sources',
        'authors',
    ];

    protected function casts(): array {
        return [
            'categories' => 'array',
            'sources' => 'array',
            'authors' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
