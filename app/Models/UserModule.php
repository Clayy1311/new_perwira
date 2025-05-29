<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Module;

class UserModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id',
        'module_type',
        'expiry_date',
        'payment_method',
        'amount',
        'status',
        'status_approved',
        'admin_notes',
        'payment_screenshot',
        'payment_status',
        'total_price',
        'whatsapp_number',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'string',
        'status_approved' => 'string',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status_approved', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_approved', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_approved', 'rejected');
    }

    public function isActiveAndApproved()
    {
        return $this->status === 'active' && $this->status_approved === 'approved';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}