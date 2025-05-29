<?php

namespace App\Http\Controllers;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
class UserModuleController extends Controller
{
    public function allClasses()
    {
        $allModules = Module::with('points')
                        ->orderBy('created_at', 'desc')
                        ->paginate(8); // <-- ganti get() jadi paginate(8)
    
        $userApprovedModuleIds = Auth::user() ? Auth::user()->approvedModules->pluck('id')->toArray() : [];
    
        return view('user.modules.all_class', compact('allModules', 'userApprovedModuleIds'));
    }
    
}
