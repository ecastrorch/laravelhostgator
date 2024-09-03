<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'trailer_link',
        'stream_link',
        'cover_image',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($movie) {
            $movie->slug = Str::slug($movie->name);
        });
    }

    // Relación de muchos a muchos con géneros
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
