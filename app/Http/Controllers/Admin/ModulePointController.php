<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Module; // Import model Module
use App\Models\ModulePoint; // Import model ModulePoint
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus file

class ModulePointController extends Controller
{
    /**
     * Menampilkan daftar point untuk modul tertentu.
     * @param  \App\Models\Module  $module (Route Model Binding)
     */
    public function index(Module $module)
    {
        // Ambil point-point yang aktif dan urutkan
        $points = $module->points()->orderBy('order')->paginate(10);
        return view('admin.module_points.index', compact('module', 'points'));
    }

    /**
     * Menampilkan form untuk membuat point baru.
     * @param  \App\Models\Module  $module
     */
    public function create(Module $module)
    {
        // Otomatis tentukan order berikutnya
        $nextOrder = $module->points()->max('order') + 1;
        return view('admin.module_points.create', compact('module', 'nextOrder'));
    }

    /**
     * Menyimpan point baru ke database.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     */
    public function store(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
            'type' => 'required|in:video,pdf,text,image,other',
            'content_url' => 'nullable|string', // Validasi file akan dilakukan manual
            'content_file' => 'nullable|file|mimes:mp4,mov,ogg,pdf,jpg,jpeg,png,gif|max:51200', // Max 50MB
            'content_text' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $contentUrl = $request->input('content_url'); // Default dari input URL

        // Jika ada file yang diupload
        if ($request->hasFile('content_file')) {
            $path = $request->file('content_file')->store('public/module_point_files');
            $contentUrl = Storage::url($path); // Dapatkan URL publik dari file yang disimpan
        } elseif ($request->input('type') == 'text') {
            $contentUrl = null; // Pastikan URL kosong jika tipe teks
        }


        $module->points()->create([
            'title' => $request->title,
            'order' => $request->order,
            'type' => $request->type,
            'content_url' => $contentUrl,
            'content_text' => $request->input('content_text'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.modules.points.index', $module)->with('success', 'Point modul berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit point.
     * @param  \App\Models\Module  $module
     * @param  \App\Models\ModulePoint  $point
     */
    public function edit(Module $module, ModulePoint $point)
    {
        // Pastikan point ini milik modul yang benar
        if ($point->module_id !== $module->id) {
            abort(404);
        }
        return view('admin.module_points.edit', compact('module', 'point'));
    }

    /**
     * Memperbarui point.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @param  \App\Models\ModulePoint  $point
     */
    public function update(Request $request, Module $module, ModulePoint $point)
    {
        // Pastikan point ini milik modul yang benar
        if ($point->module_id !== $module->id) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
            'type' => 'required|in:video,pdf,text,image,other',
            'content_url' => 'nullable|string',
            'content_file' => 'nullable|file|mimes:mp4,mov,ogg,pdf,jpg,jpeg,png,gif|max:51200',
            'content_text' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $contentUrl = $request->input('content_url'); // Default dari input URL atau URL lama

        // Jika ada file baru diupload
        if ($request->hasFile('content_file')) {
            // Hapus file lama jika ada
            if ($point->content_url && Storage::exists(str_replace('/storage/', 'public/', $point->content_url))) {
                Storage::delete(str_replace('/storage/', 'public/', $point->content_url));
            }
            $path = $request->file('content_file')->store('public/module_point_files');
            $contentUrl = Storage::url($path);
        } elseif ($request->boolean('remove_file')) { // Jika checkbox 'Hapus File' dicentang
             if ($point->content_url && Storage::exists(str_replace('/storage/', 'public/', $point->content_url))) {
                Storage::delete(str_replace('/storage/', 'public/', $point->content_url));
            }
            $contentUrl = null;
        } elseif ($request->input('type') == 'text') {
             $contentUrl = null; // Pastikan URL kosong jika tipe teks
        }


        $point->update([
            'title' => $request->title,
            'order' => $request->order,
            'type' => $request->type,
            'content_url' => $contentUrl,
            'content_text' => $request->input('content_text'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.modules.points.index', $module)->with('success', 'Point modul berhasil diperbarui!');
    }

    /**
     * Menghapus point.
     * @param  \App\Models\Module  $module
     * @param  \App\Models\ModulePoint  $point
     */
    public function destroy(Module $module, ModulePoint $point)
    {
        // Pastikan point ini milik modul yang benar
        if ($point->module_id !== $module->id) {
            abort(404);
        }

        // Hapus file terkait jika ada
        if ($point->content_url && Storage::exists(str_replace('/storage/', 'public/', $point->content_url))) {
            Storage::delete(str_replace('/storage/', 'public/', $point->content_url));
        }

        $point->delete();

        return redirect()->route('admin.modules.points.index', $module)->with('success', 'Point modul berhasil dihapus!');
    }
}