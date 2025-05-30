<?php

namespace App\Models;

use App\Models\UserModule;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'phone',
        'email_verified_at',
        'avatar',
        'google_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->modules()->delete();
        });
    }

    public function modules()
    {
        return $this->hasMany(UserModule::class);
    }

    public function hasPendingModule(): bool
    {
        return $this->modules()->where('status_approved', 'pending')->exists();
    }

    public function hasActiveModule(): bool
    {
        return $this->modules()
                    ->where('status_approved', 'approved')
                    ->where(function($query) {
                        $query->whereNull('expiry_date')
                              ->orWhere('expiry_date', '>', Carbon::now());
                    })
                    ->exists();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function approvedModules()
    {
        return $this->modules()
                    ->where('status_approved', 'approved')
                    ->where(function($query) {
                        $query->whereNull('expiry_date')
                              ->orWhere('expiry_date', '>', Carbon::now());
                    });
    }

    public function moduleProgress()
    {
        return $this->hasMany(UserModuleProgress::class);
    }

    public function sendEmailVerificationNotification()
{
    $this->notify(new VerifyEmailNotification);
}
}