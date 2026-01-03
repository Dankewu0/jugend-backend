<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title', 'is_locked', 'slug'];
    public function Post()
    {
        return $this->hasMany(Post::class);
    }
    protected $casts = [
        'is_locked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
