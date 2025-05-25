<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini untuk membuat slug
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Module extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // Otomatis membuat slug saat modul dibuat atau diperbarui
    protected static function booted()
    {
        static::creating(function ($module) {
            $module->slug = Str::slug($module->name);
        });
    }
    public function points(): HasMany
    {
        return $this->hasMany(ModulePoint::class);
    }
    // Nanti akan ada relasi ke UserModule jika dibutuhkan untuk menampilkan harga, dll.
}