<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ModulePoint;
use App\Models\UserModuleProgress;

class ModuleDetailController extends Controller
{
    public function detailPoints(Module $module, ModulePoint $point = null)
    {
        $module->load('points');
        $points = $module->points;

        $hasAccess = Auth::user() ? Auth::user()->hasActiveModule() : false;

        if (!$hasAccess && Auth::check()) {
            return redirect()->route('all.class')->with('error', 'Anda belum memiliki akses ke modul ini atau modul Anda sudah kedaluwarsa.');
        } elseif (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login untuk melihat detail modul.');
        }

        if (!$point && $points->isNotEmpty()) {
            $point = $points->first();
        } elseif ($point && $point->module_id !== $module->id) {
            abort(404, 'Poin tidak ditemukan dalam modul ini.');
        }

        $completedPointIds = Auth::user()
            ->moduleProgress()
            ->where('module_id', $module->id)
            ->pluck('point_id')
            ->toArray();

        // Pass $point ke view agar kontennya bisa ditampilkan
        return view('user.modules.detailmodule', compact('module', 'points', 'completedPointIds', 'point'));
    }

    public function markPointAsComplete(Request $request, Module $module, ModulePoint $point)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Anda harus login.'], 401);
        }
        

        if (!Auth::user()->hasActiveModule()) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke modul ini.'], 403);
        }

        if ($point->module_id !== $module->id) {
            return response()->json(['message' => 'Poin ini bukan bagian dari modul yang ditentukan.'], 400);
        }

        UserModuleProgress::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'point_id' => $point->id,
            ],
            [
                'module_id'    => $module->id,
                'completed_at' => now(),
            ]
        );

        return response()->json(['message' => 'Poin berhasil ditandai sebagai selesai.']);
    }
}