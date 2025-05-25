<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini

class ModulePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'order',
        'type',
        'content_url',
        'content_text',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Dapatkan modul yang memiliki point ini.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}