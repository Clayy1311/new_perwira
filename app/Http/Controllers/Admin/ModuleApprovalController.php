<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ModuleApprovalController extends Controller
{
    public function index()
    {
        $pendingModules = UserModule::with('user')
            ->where('status_approved', 'pending')
            ->paginate(10);

        return view('admin.index', compact('pendingModules'));
    }

    public function approve(UserModule $module)
    {
        // Pastikan $expiryDate dihitung sebelum digunakan
        $expiryDate = null; // Default untuk lifetime
        if ($module->module_type === 'yearly') {
            $expiryDate = Carbon::now()->addYears(1);
        }

        // Lakukan update pada modul
        $module->update([
            'status_approved' => 'approved',
            'expiry_date' => $expiryDate,
        ]);

        // Inisialisasi $message di sini, sebelum modifikasi apa pun
        // Baris ini harus ada dan dieksekusi sebelum baris yang menggunakan $message atau $expiryDate->format()
        $message = 'Modul disetujui.';

        // Lanjutkan memodifikasi $message berdasarkan $expiryDate
        if ($expiryDate) {
            $message .= ' Hingga: ' . $expiryDate->format('d M Y');
        } else {
            $message .= ' (Lifetime)';
        }

        // Redirect dengan pesan sukses
        return back()->with('success', $message);
    }

    public function reject(Request $request, UserModule $module)
    {
        $request->validate(['notes' => 'required|string|max:255']);

        $module->update([
            'status' => 'inactive',
            'status_approved' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return back()->with('error', 'Modul berhasil ditolak: ' . $request->notes);
    }
}