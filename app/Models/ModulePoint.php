<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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
        'video_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserModuleProgress::class);
    }

    public function getIsCompletedAttribute(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->userProgress()
                    ->where('user_id', Auth::id())
                    ->whereNotNull('completed_at')
                    ->exists();
    }
}