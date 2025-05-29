<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'module_type',
        'price',
        'status_approved',
    ];

    protected static function booted()
    {
        static::creating(function ($module) {
            $module->slug = Str::slug($module->name);
        });
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }

        return 'https://via.placeholder.com/400x200?text=No+Image';
    }

    public function points(): HasMany
    {
        return $this->hasMany(ModulePoint::class)->orderBy('order');
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserModuleProgress::class);
    }

    public function getCompletionPercentageAttribute($user = null): float
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return 0.0;
        }

        $totalPoints = $this->points->count();
        if ($totalPoints === 0) {
            return 0.0;
        }

        $completedPointsCount = $this->userProgress()
                                     ->where('user_id', $user->id)
                                     ->whereNotNull('completed_at')
                                     ->count();

        return round(($completedPointsCount / $totalPoints) * 100, 2);
    }

    public function getProgressForCurrentUserAttribute(): float
    {
        return $this->getCompletionPercentageAttribute(Auth::user());
    }
}