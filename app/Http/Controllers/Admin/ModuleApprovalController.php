<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Carbon\Carbon; // Pastikan ini diimport

class ModuleApprovalController extends Controller
{
    public function index()
    {
        $pendingModules = UserModule::with('user', 'module') // Eager load 'module' juga untuk ditampilkan
            ->where('status_approved', 'pending')
            ->paginate(10);

        return view('admin.index', compact('pendingModules'));
    }

    public function approve(UserModule $userModule) // Ganti $module menjadi $userModule agar konsisten dengan route
    {
        $expiryDate = null; // Default untuk lifetime

        // Jika modul berjenis 'yearly', hitung tanggal kedaluwarsa 1 tahun dari sekarang
        if ($userModule->module_type === 'yearly') {
            $expiryDate = Carbon::now()->addYears(1);
        }

        // Lakukan update pada userModule
        $userModule->update([
            'status_approved' => 'approved', // Pastikan ini 'approved'
            'expiry_date' => $expiryDate,
            'admin_notes' => null, // Hapus catatan admin jika sebelumnya ada
        ]);

        // Buat pesan sukses
        $message = 'Modul "'  . '" untuk user ' . ($userModule->user->name ?? 'Tidak Diketahui') . ' berhasil disetujui.';

        if ($expiryDate) {
            $message .= ' Aktif hingga: ' . $expiryDate->format('d M Y');
        } else {
            $message .= ' (Lifetime)';
        }

        return back()->with('success', $message);
    }

    public function reject(Request $request, UserModule $userModule) // Ganti $module menjadi $userModule
    {
        $request->validate([
            'notes' => 'required|string|max:255',
        ]);

        $userModule->update([
            'status_approved' => 'rejected', // Pastikan ini 'rejected'
            'expiry_date' => null, // Pastikan tanggal kadaluarsa dihapus jika ditolak
            'admin_notes' => $request->notes, // Simpan catatan penolakan dari admin
        ]);

        $message = 'Modul "' . ($userModule->module->name ?? 'Modul Tidak Ditemukan') . '" untuk user ' . ($userModule->user->name ?? 'Tidak Diketahui') . ' berhasil ditolak.';
        $message .= ' Catatan: ' . $request->notes;

        return back()->with('error', $message); // Menggunakan 'error' untuk pesan penolakan
    }
}