<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk mengelola file

class ResearchController extends Controller
{
    /**
     * Menampilkan daftar semua research.
     */
    public function index()
    {
        $researches = Research::latest()->paginate(8);
        return view('admin.research.index', compact('researches'));
    }

    /**
     * Menampilkan form untuk membuat research baru.
     */
    public function create()
    {
        return view('admin.research.create_research');
    }

    /**
     * Menyimpan research baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:10240',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:20048'
        ]);
    
        // Simpan file PDF
        $pdfPath = $request->file('pdf_file')->store('uploads/pdf', 'public');
        // Simpan file gambar
        $imagePath = $request->file('image')->store('uploads/images', 'public');
    
        Research::create([
            'title' => $request->title,
            'file_path' => $pdfPath,
            'image' => $imagePath,
        ]);
    
        return redirect()->route('admin.research')->with('success', 'Research berhasil ditambahkan!');
    }
    

    /**
     * Menampilkan research tertentu.
     */
    public function show(Research $research)
    {
        // Jika Anda ingin menampilkan PDF langsung di browser (iframe)
        // Pastikan asset() mengarah ke file yang benar di public/storage
        return view('researches.show', compact('research'));
    }

    /**
     * Menampilkan form untuk mengedit research.
     */
    public function edit(Research $research)
    {
        return view('admin.research.research_edit', compact('research'));
    }

    /**
     * Memperbarui research di database.
     */
    public function update(Request $request, Research $research)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'pdf_file' => 'nullable|mimes:pdf|max:10240',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:20048'
    ]);

    $data = ['title' => $request->title];

    if ($request->hasFile('pdf_file')) {
        // Hapus PDF lama
        if ($research->file_path && Storage::disk('public')->exists($research->file_path)) {
            Storage::disk('public')->delete($research->file_path);
        }
        $data['file_path'] = $request->file('pdf_file')->store('uploads/pdf', 'public');
    }

    if ($request->hasFile('image')) {
        // Hapus image lama
        if ($research->image_path && Storage::disk('public')->exists($research->image_path)) {
            Storage::disk('public')->delete($research->image_path);
        }
        $data['image_path'] = $request->file('image')->store('uploads/images', 'public');
    }

    $research->update($data);

    return redirect()->route('admin.research')->with('success', 'Research berhasil diperbarui!');
}


    /**
     * Menghapus research dari database.
     */
    public function destroy(Research $research)
    {
        // Hapus file PDF dari storage
        if ($research->file_path && Storage::exists('public/' . $research->file_path)) {
            Storage::delete('public/' . $research->file_path);
        }

        $research->delete();

        return redirect()->route('admin.research')->with('success', 'Research berhasil dihapus!');
    }
}