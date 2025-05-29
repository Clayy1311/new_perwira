<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Research;

class ResearchUserController extends Controller
{
    public function index(Request $request)
    {
        // Jika ada request untuk melihat PDF tertentu
        if ($request->has('view_pdf')) {
            $selectedResearch = Research::find($request->input('view_pdf'));
            return view('user.research.index', compact('selectedResearch'));
        }

        // Jika tidak ada request view_pdf, tampilkan daftar research
        $researches = Research::orderBy('created_at', 'desc')->paginate(6);
        return view('user.research.index', compact('researches'));
    }

}
