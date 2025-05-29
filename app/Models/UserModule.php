<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <--- INI YANG HILANG! TAMBAHKAN INI
use App\Models\Module; // <--- INI YANG HILANG! TAMBAHKAN INI

class UserModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id', // Pastikan kolom ini ada di tabel user_modules kamu
        'module_type',
        'expiry_date',
        'payment_method',
        'amount',
        'status',          // existing (active/inactive)
        'status_approved', // baru (pending/approved/rejected)
        'admin_notes',
        'payment_screenshot', // Jika ada di tabel
        'payment_status',     // Jika ada di tabel
        'total_price',        // Jika ada di tabel
        'whatsapp_number',    // Jika ada di tabel
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'string',
        'status_approved' => 'string',
        // 'is_admin' => 'boolean' // Ini biasanya di model User, bukan UserModule. Hapus jika tidak relevan di UserModule.
    ];

    // Scope untuk status existing
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Scope untuk status approval
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

    // Helper method
    public function isActiveAndApproved()
    {
        return $this->status === 'active' && $this->status_approved === 'approved';
    }

    // Relasi ke User
    public function user(): BelongsTo // Tambahkan return type hint
    {
        // Asumsi kolom foreign key di tabel 'user_modules' adalah 'user_id'
        // dan model user adalah App\Models\User
        return $this->belongsTo(User::class);
    }

    // Relasi ke Module (Ini adalah yang menyebabkan error sebelumnya)
    public function module(): BelongsTo // Tambahkan return type hint
    {
        return $this->belongsTo(Module::class);
    }
}