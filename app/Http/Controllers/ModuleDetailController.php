<?php

namespace App\Http\Controllers;

use App\Models\Module; // Import model Module
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ModuleDetailController extends Controller
{
    /**
     * Menampilkan detail satu modul untuk user (termasuk points-nya).
     * Menerima model Module berdasarkan ID melalui route model binding.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Module $module): View // Menggunakan nama 'show' adalah konvensi umum untuk detail
    {
        $user = Auth::user();

        // Pastikan pengguna memiliki akses ke modul ini dan belum kedaluwarsa
        $hasAccess = $user->hasActiveModule();

        if (!$hasAccess) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke modul ini atau modul Anda sudah kedaluwarsa.');
        }

        // Ambil poin-poin yang aktif untuk modul ini
        $points = $module->points()->where('is_active', true)->orderBy('order')->get();

        // Kirim objek modul tunggal dan poin-poinnya ke view
        return view('user.modules.detailmodule', compact('module', 'points'));
    }
}