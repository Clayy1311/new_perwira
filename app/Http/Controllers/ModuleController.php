<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
class ModuleController extends Controller
{
    // ...
public function processSelection(Request $request)
{
    // ... (validasi dan penyimpanan UserModule)

    $userModule->status_approved = 'pending'; // Pastikan ini diset!
    $userModule->save();

    // Redirect ke dashboard, di mana DashboardController akan menampilkan status pending
    return redirect()->route('dashboard')->with('success', 'Modul Anda telah berhasil dipilih dan sedang menunggu persetujuan admin.');
}
public function allClasses()
{
    $allModules = Module::with('points')
                    ->orderBy('created_at', 'desc')
                    ->paginate(8); // <-- ganti get() jadi paginate(8)

    $userApprovedModuleIds = Auth::user() ? Auth::user()->approvedModules->pluck('id')->toArray() : [];

    return view('user.modules.all_class', compact('allModules', 'userApprovedModuleIds'));
}


}
