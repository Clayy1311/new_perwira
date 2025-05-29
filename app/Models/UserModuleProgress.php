<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModuleProgress extends Model
{
    use HasFactory;

    protected $table = 'user_module_progress';

    protected $fillable = [
        'user_id',
        'module_id',
        'point_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function point()
    {
        // Pastikan ini menunjuk ke model ModulePoint, bukan Point
        return $this->belongsTo(ModulePoint::class, 'point_id');
    }
}