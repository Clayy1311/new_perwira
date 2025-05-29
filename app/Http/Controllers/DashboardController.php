<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\ModulePoint;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $approvedModules = collect();
        $pendingModule = null;
        $noModuleSelected = true;

        $userModulesCollection = $user->modules()->with('module')->get();

        if ($userModulesCollection->isNotEmpty()) {
            $userModuleHistory = $userModulesCollection->filter(function($userModule) {
                if ($userModule->status_approved === 'approved') {
                    if ($userModule->module_type === 'eternal') {
                        return true;
                    } elseif ($userModule->module_type === 'wolfpack' && $userModule->expiry_date && $userModule->expiry_date->isFuture()) {
                        return true;
                    }
                }
                return false;
            });

            $pendingModule = $userModulesCollection->where('status_approved', 'pending')->first();

            if ($userModuleHistory->isNotEmpty() || !is_null($pendingModule)) {
                $noModuleSelected = false;
            }
            
            if($userModuleHistory->isNotEmpty()){
                $approvedModules = Module::all();
            }
        }else{
              return  redirect('/membership');
        }

        

        return view('user.approved_module', compact('approvedModules'));
    }

    /**
     * Menampilkan detail satu modul untuk user (termasuk points-nya).
     * Sekarang menerima model Module berdasarkan ID secara default.
     * @param  \App\Models\Module  $module
     */
    public function showModule(Module $module): View // <--- TIDAK PERLU DIUBAH, Laravel akan bind berdasarkan ID secara default
    {
        $user = Auth::user();

        $hasAccess = $user->modules()
                         ->where('module_id', $module->id)
                         ->where('status_approved', 'approved')
                         ->where(function($query) {
                             $query->whereNull('expiry_date')
                                   ->orWhere('expiry_date', '>', now());
                         })
                         ->exists();

        if (!$hasAccess) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke modul ini atau modul Anda sudah kedaluwarsa.');
        }

        $points = $module->points()->where('is_active', true)->orderBy('order')->get();

        return view('user.modules.show', compact('module', 'points'));
    }
   
}