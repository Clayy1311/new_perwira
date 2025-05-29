<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str facade untuk slug

class News extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'author',
        'published_at',
    ];

    // Tentukan casting untuk kolom tertentu jika diperlukan (misal: published_at sebagai datetime)
    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Method untuk menghasilkan slug secara otomatis sebelum disimpan
    public static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            $news->slug = Str::slug($news->title);
        });

        static::updating(function ($news) {
            if ($news->isDirty('title')) { // Hanya update slug jika judul berubah
                $news->slug = Str::slug($news->title);
            }
        });
    }
}